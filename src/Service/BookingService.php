<?php

namespace App\Service;

use App\Entity\Booking;
use App\Entity\CartHistory;
use App\Entity\IssuedTicket;
use App\Entity\User;
use App\Enum\BookingStatus;
use App\Enum\CartStatus;
use App\Enum\IssuedTicketStatus;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class BookingService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private BookingRepository $bookingRepository,
        private QrCodeService $qrCodeService,
        private MailerInterface $mailer
    ) {}

    public function createPendingBooking(CartHistory $cart, string $paymentIntentId, ?User $user): Booking
    {
        $cart->setStatus(CartStatus::PROCESSING);

        $booking = new Booking();
        $booking->setCart($cart);
        $booking->setTransactionId($paymentIntentId);
        $booking->setStatus(BookingStatus::PENDING);
        $booking->setUser($user);

        $this->entityManager->persist($booking);
        $this->entityManager->flush();

        return $booking;
    }

    public function completeBooking(string $transactionId): ?Booking
    {
        $booking = $this->bookingRepository->findOneBy(['transactionId' => $transactionId]);

        if (!$booking || $booking->getStatus() !== BookingStatus::PENDING) {
            return null;
        }

        $booking->setStatus(BookingStatus::COMPLETED);
        $booking->getCart()->setStatus(CartStatus::COMPLETED);

        foreach ($booking->getCart()->getCartItems() as $item) {
            for ($i = 0; $i < $item->getQuantity(); $i++) {
                $issuedTicket = new IssuedTicket();
                $issuedTicket->setBooking($booking);
                $issuedTicket->setTicketType($item->getTicketType());
                $issuedTicket->setStatus(IssuedTicketStatus::ACTIVE);
                $issuedTicket->setQrCodeId('ticket-' . uniqid());

                $this->entityManager->persist($issuedTicket);
            }
        }

        $this->entityManager->flush();

        $pdfContent = $this->qrCodeService->generateQrCodePdf($transactionId);

        $email = (new TemplatedEmail())
            ->from('no-reply@show-time.com')
            ->to($booking->getUser()->getEmail())
            ->subject('Your Tickets')
            ->htmlTemplate('public/checkout/_tickets_email.html.twig')
            ->attach($pdfContent, 'tickets.pdf', 'application/pdf');

        $this->mailer->send($email);

        return $booking;
    }
}
