<?php

namespace App\Controller\admin;

use App\Entity\TicketType;
use App\Filter\BandFilter;
use App\Filter\TicketTypeFilter;
use App\Form\BandFilterForm;
use App\Form\TicketTypeFilterForm;
use App\Form\TicketTypeForm;
use App\Repository\TicketTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TicketTypeController extends AbstractController
{
    #[Route('/admin/ticket/type', name: 'app_admin_ticket_type', methods: ['GET'])]
    public function index(
        TicketTypeRepository $ticketTypeRepository,
        PaginatorInterface $paginator,
        Request $request): Response
    {
        $filter = new TicketTypeFilter();
        $form = $this->createForm(TicketTypeFilterForm::class, $filter);
        $form->handleRequest($request);

        $pagination = $paginator->paginate(
            $ticketTypeRepository->getTicketTypesQueryBuilder($filter),
            $request->query->getInt('page', 1), 10);

        return $this->render('/admin/ticket_type/index.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView(),
        ]);
    }

    #[Route('/admin/ticket/type/show/{id}', name: 'app_admin_ticket_type_show', methods: ['GET'])]
    public function show(TicketType $ticketType): Response
    {
        return $this->render('/admin/ticket_type/show.html.twig', [
            'ticket' => $ticketType,
        ]);
    }

    #[Route('/admin/ticket/type/new', name: 'app_admin_ticket_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ticket = new TicketType();
        $form = $this->createForm(TicketTypeForm::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ticket);
            $entityManager->flush();

            $this->addFlash('success', 'Ticket type was successfully created.');

            return $this->redirectToRoute('app_admin_ticket_type');
        }

        return $this->render('/admin/ticket_type/new.html.twig', [
            'form' => $form->createView(),
            'buttonText' => 'Create',
        ]);
    }

    #[Route('/admin/ticket/type/edit/{id}', name: 'app_admin_ticket_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TicketType $ticket, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TicketTypeForm::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Ticket type was successfully updated.');

            return $this->redirectToRoute('app_admin_ticket_type');
        }

        return $this->render('/admin/ticket_type/new.html.twig', [
            'form' => $form->createView(),
            'buttonText' => 'Update',
        ]);
    }

    #[Route('/admin/ticket/type/delete/{id}', name: 'app_admin_ticket_type_delete', methods: ['POST'])]
    public function delete(Request $request, TicketType $ticket, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ticket->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ticket);
            $entityManager->flush();
        }

        $this->addFlash('success', 'Ticket type was successfully deleted.');

        return $this->redirectToRoute('app_admin_ticket_type');
    }
}
