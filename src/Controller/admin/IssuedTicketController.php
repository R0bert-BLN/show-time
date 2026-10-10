<?php

namespace App\Controller\admin;

use App\Filter\TicketIssuedFilter;
use App\Filter\TicketPaymentFilter;
use App\Form\TicketIssuedFilterForm;
use App\Form\TicketPaymentFilterForm;
use App\Repository\IssuedTicketRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IssuedTicketController extends AbstractController
{
    #[Route('/admin/issued/ticket', name: 'app_admin_issued_ticket')]
    public function index(
        IssuedTicketRepository $issuedTicketRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response
    {
        $filter = new TicketIssuedFilter();
        $form = $this->createForm(TicketIssuedFilterForm::class, $filter);
        $form->handleRequest($request);

        $pagination = $paginator->paginate(
            $issuedTicketRepository->getIssuedTicketsQueryBuilder($filter),
            $request->query->getInt('page', 1), 10);

        return $this->render('/admin/issued_ticket/index.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView(),
        ]);
    }
}
