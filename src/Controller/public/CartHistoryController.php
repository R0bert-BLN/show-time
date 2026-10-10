<?php

namespace App\Controller\public;

use App\Entity\TicketType;
use App\Service\CartHistoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CartHistoryController extends AbstractController
{
    #[Route('/cart', name: 'app_cart', methods: ['GET'])]
    public function index(CartHistoryService $cartHistoryService): Response
    {
        return $this->render('public/cart_history/index.html.twig', [
            'cart' => $cartHistoryService->getCartItems($this->getUser()),
            'total' => $cartHistoryService->getTotalAmount($this->getUser()),
            'stripe_public_key' => $_ENV['STRIPE_PUBLIC_KEY'],
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add', methods: ['POST'])]
    public function add(
        TicketType $ticketType, Request $request, CartHistoryService $cartHistoryService
    ): Response
    {
        $quantity = $request->request->getInt('quantity', 1);
        $user = $this->getUser();

        if ($quantity <= 0) {
            return new Response(null, Response::HTTP_BAD_REQUEST);
        }

        $cartHistoryService->addItemToCart($user, $ticketType, $quantity);

        $this->addFlash('success', sprintf('%d x %s ticket added to cart.', $quantity, $ticketType->getName()));

        $referer = $request->headers->get('referer');

        if (!$referer) {
            $referer = $this->generateUrl('app_festival');
        }

        return $this->redirect($referer);
    }

    #[Route('cart/update/{id}', name: 'app_cart_update', methods: ['POST'], format: 'turbo-stream')]
    public function update(TicketType $ticketType, Request $request, CartHistoryService $cartHistoryService): Response
    {
        $quantity = $request->request->getInt('quantity');

        if ($quantity <= 0) {
            return $this->redirectToRoute('app_cart_remove', ['id' => $ticketType->getId()]);
        }

        $cartHistoryService->updateItemQuantity($this->getUser(), $ticketType, $quantity);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/{id}', name: 'app_cart_remove', methods: ['POST'])]
    public function remove(TicketType $ticketType, CartHistoryService $cartHistoryService): Response
    {
        $cartHistoryService->removeItemFromCart($this->getUser(), $ticketType);

        return $this->redirectToRoute('app_cart');
    }
}
