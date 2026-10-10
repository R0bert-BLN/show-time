<?php

namespace App\Service;

use App\Entity\CartHistory;
use App\Entity\CartItem;
use App\Entity\TicketType;
use App\Entity\User;
use App\Enum\CartStatus;
use App\Repository\CartHistoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartHistoryService
{
    private const CART_SESSION_KEY = 'app_cart';
    private SessionInterface $session;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly CartHistoryRepository $cartHistoryRepository,
        private readonly RequestStack $requestStack)
    {
        $this->session = $requestStack->getSession();
    }

    public function updateItemQuantity(?User $user, TicketType $ticketType, int $quantity): void
    {
        if ($user) {
            $this->updateDatabaseItemQuantity($user, $ticketType, $quantity);
        } else {
            $this->updateSessionItemQuantity($ticketType, $quantity);
        }
    }

    public function removeItemFromCart(?User $user, TicketType $ticketType): void
    {
        if ($user) {
            $this->removeItemFromDatabaseCart($user, $ticketType);
        } else {
            $this->removeItemFromSessionCart($ticketType);
        }
    }

    public function getActiveCart(?User $user): CartHistory
    {
        if ($user) {
            $cart = $this->cartHistoryRepository->findOneBy(['user' => $user, 'status' => CartStatus::ACTIVE]);

            if (null === $cart) {
                $cart = new CartHistory();
                $cart->setUser($user);
                $cart->setStatus(CartStatus::ACTIVE);
                $cart->setCreatedAt(new \DateTimeImmutable());
                $this->entityManager->persist($cart);
            }

            return $cart;
        }


        $cart = new CartHistory();
        $cart->setStatus(CartStatus::ACTIVE);

        $sessionCartItems = $this->session->get(self::CART_SESSION_KEY, []);
        if (empty($sessionCartItems)) {
            return $cart;
        }

        $ticketIds = array_keys($sessionCartItems);
        $ticketTypes = $this->entityManager->getRepository(TicketType::class)->findBy(['id' => $ticketIds]);

        $ticketMap = [];
        foreach ($ticketTypes as $ticketType) {
            $ticketMap[$ticketType->getId()] = $ticketType;
        }

        foreach ($sessionCartItems as $ticketId => $quantity) {
            if (isset($ticketMap[$ticketId])) {
                $cartItem = new CartItem();
                $cartItem->setTicketType($ticketMap[$ticketId]);
                $cartItem->setQuantity($quantity);

                $cart->addCartItem($cartItem);
            }
        }

        return $cart;
    }

    public function getTotalAmount(?User $user): float
    {
        $total = 0.0;
        $items = $this->getCartItems($user);

        foreach ($items as $item) {
            $total += $item['ticketType']->getPrice() * $item['quantity'];
        }

        return $total;
    }

    private function updateDatabaseItemQuantity(User $user, TicketType $ticketType, int $quantity): void
    {
        $cart = $this->cartHistoryRepository->findOneBy(['user' => $user, 'status' => CartStatus::ACTIVE]);

        foreach ($cart->getCartItems() as $item) {
            if ($item->getTicketType()->getId() === $ticketType->getId()) {
                $item->setQuantity($quantity);

                $this->entityManager->persist($item);
                $this->entityManager->flush();

                return;
            }
        }
    }

    private function updateSessionItemQuantity(TicketType $ticketType, int $quantity): void
    {
        $sessionCart = $this->session->get(self::CART_SESSION_KEY, []);
        $sessionCart[$ticketType->getId()] = $quantity;

        $this->session->set(self::CART_SESSION_KEY, $sessionCart);
    }

    private function removeItemFromDatabaseCart(User $user, TicketType $ticketType): void
    {
        $cart = $this->cartHistoryRepository->findOneBy(['user' => $user, 'status' => CartStatus::ACTIVE]);

        foreach ($cart->getCartItems() as $item) {
            if ($item->getTicketType()->getId() === $ticketType->getId()) {
                $this->entityManager->remove($item);
                $this->entityManager->flush();

                return;
            }
        }
    }

    private function removeItemFromSessionCart(TicketType $ticketType): void
    {
        $sessionCart = $this->session->get(self::CART_SESSION_KEY, []);
        unset($sessionCart[$ticketType->getId()]);

        $this->session->set(self::CART_SESSION_KEY, $sessionCart);
    }

    public function getCartItems(?User $user): array
    {
        if ($user) {
            $cart = $this->cartHistoryRepository->findOneBy(['user' => $user, 'status' => CartStatus::ACTIVE]);

            if (!$cart) {
                return [];
            }

            return $cart->getCartItems()->map(function (CartItem $item) {
                return [
                    'ticketType' => $item->getTicketType(),
                    'quantity' => $item->getQuantity()
                ];
            })->toArray();
        } else {
            $sessionCart = $this->session->get(self::CART_SESSION_KEY, []);
            $cart = [];
            $ticketsIds = array_keys($sessionCart);

            if (empty($ticketsIds)) {
                return [];
            }

            $ticketTypes = $this->entityManager->getRepository(TicketType::class)->findBy(['id' => $ticketsIds]);

            $ticketMap = [];
            foreach ($ticketTypes as $ticketType) {
                $ticketMap[$ticketType->getId()] = $ticketType;
            }

            foreach ($sessionCart as $ticketId => $quantity) {
                if (isset($ticketMap[$ticketId])) {
                    $cart[] = [
                        'ticketType' => $ticketMap[$ticketId],
                        'quantity' => $quantity
                    ];
                }
            }

            return $cart;
        }
    }

    public function addItemToCart(?User $user, TicketType $ticketType, int $quantity): void
    {
        if ($user) {
            $this->addItemToDatabaseCart($user, $ticketType, $quantity);
        } else {
            $this->addItemToSessionCart($ticketType, $quantity);
        }
    }

    private function addItemToDatabaseCart(User $user, TicketType $ticketType, int $quantity): void
    {
        $cart = $this->cartHistoryRepository->findOneBy(['user' => $user, 'status' => CartStatus::ACTIVE]);
        if (!$cart) {
            $cart = new CartHistory();
            $cart->setUser($user);
            $cart->setStatus(CartStatus::ACTIVE);

            $this->entityManager->persist($cart);
        }

        $cartItem = null;
        foreach ($cart->getCartItems() as $item) {
            if ($item->getTicketType()->getId() === $ticketType->getId()) {
                $cartItem = $item;
                break;
            }
        }

        if ($cartItem) {
            $cartItem->setQuantity($cartItem->getQuantity() + $quantity);
        } else {
            $cartItem = new CartItem();
            $cartItem->setCart($cart);
            $cartItem->setTicketType($ticketType);
            $cartItem->setQuantity($quantity);

            $this->entityManager->persist($cartItem);
        }

        $this->entityManager->flush();
    }

    private function addItemToSessionCart(TicketType $ticketType, int $quantity): void
    {
        $cart = $this->session->get(self::CART_SESSION_KEY, []);
        $ticketId = $ticketType->getId();

        if (isset($cart[$ticketId])) {
            $cart[$ticketId] += $quantity;
        } else {
            $cart[$ticketId] = $quantity;
        }

        $this->session->set(self::CART_SESSION_KEY, $cart);
    }
}
