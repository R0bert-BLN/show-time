<?php

namespace App\Controller\admin;

use App\Filter\TicketPaymentFilter;
use App\Filter\TicketTypeFilter;
use App\Form\TicketPaymentFilterForm;
use App\Form\TicketTypeFilterForm;
use App\Repository\BookingRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TicketPaymentController extends AbstractController
{
    #[Route('/admin/ticket/payment', name: 'app_admin_ticket_payment')]
    public function index(
        BookingRepository $bookingRepository,
        PaginatorInterface $paginator,
        Request $request): Response
    {
        $filter = new TicketPaymentFilter();
        $form = $this->createForm(TicketPaymentFilterForm::class, $filter);
        $form->handleRequest($request);

        $pagination = $paginator->paginate(
            $bookingRepository->getTicketPaymentsQueryBuilder($filter),
            $request->query->getInt('page', 1), 10);

        return $this->render('/admin/ticket_payment/index.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView(),
        ]);
    }
}
