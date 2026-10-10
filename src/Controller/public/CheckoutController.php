<?php

namespace App\Controller\public;

use App\Entity\User;
use App\Enum\BookingStatus;
use App\Enum\CartStatus;
use App\Repository\BookingRepository;
use App\Service\BookingService;
use App\Service\CartHistoryService;
use App\Service\StripeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class CheckoutController extends AbstractController
{
    #[Route('/checkout/session/create', name: 'app_checkout_session_create', methods: ['POST'])]
    public function createSession(
        Request $request,
        EntityManagerInterface $entityManager,
        StripeService $stripeService,
        CartHistoryService $cartHistoryService,
        UserPasswordHasherInterface $userPasswordHasher,
        BookingService $bookingService): JsonResponse
    {
        $cartItems = $cartHistoryService->getCartItems($this->getUser());
        $cart = $cartHistoryService->getActiveCart($this->getUser());

        if ($this->getUser()) {
            $user = $this->getUser();
        } else {
            $data = json_decode($request->getContent(), true);

            $firstName = $data['firstName'] ?? null;
            $lastName = $data['lastName'] ?? null;
            $email = $data['email'] ?? null;

            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

            if (!$user) {
                $user = new User();
                $user->setFirstName($firstName);
                $user->setLastName($lastName);
                $user->setEmail($email);
                $user->setPassword($userPasswordHasher->hashPassword($user, 'password-' . $email));
                $user->setIsActive(false);

                $entityManager->persist($user);
                $entityManager->flush();
            }
        }

        $session = $stripeService->createCheckoutSession($cartItems);
        $bookingService->createPendingBooking($cart, $session->id, $user);

        return new JsonResponse(['id' => $session->id]);
    }

    #[Route('/checkout/success', name: 'app_checkout_success', methods: ['GET'])]
    public function success(Request $request, BookingService $bookingService, RequestStack $requestStack): Response
    {
        $sessionId = $request->query->get('session_id');
        $bookingService->completeBooking($sessionId);

        $session = $requestStack->getSession();
        $session->remove('app_cart');

        return $this->render('public/checkout/success.hml.twig');
    }

    #[Route('/checkout/cancel', name: 'app_checkout_cancel', methods: ['GET'])]
    public function cancel(Request $request, BookingRepository $bookingRepository, EntityManagerInterface $entityManager): Response
    {
        $booking = $bookingRepository->findOneBy(['transactionId' => $request->query->get('session_id')]);

        if ($booking->getStatus() !== BookingStatus::CANCELLED) {
            $booking->setStatus(BookingStatus::CANCELLED);
            $booking->getCart()->setStatus(CartStatus::ACTIVE);

            $entityManager->flush();
        }

        return $this->render('public/checkout/cancel.html.twig');
    }
}
