<?php

namespace App\Controller\admin;

use App\Entity\Band;
use App\Filter\BandFilter;
use App\Filter\FestivalFilter;
use App\Form\BandFilterForm;
use App\Form\BandForm;
use App\Form\CreateFestivalForm;
use App\Form\FestivalFilterForm;
use App\Repository\BandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BandController extends AbstractController
{
    public function __construct(private readonly CreateFestivalForm $createFestivalForm)
    {
    }

    #[Route('/admin/band', name: 'app_admin_band', methods: ['GET'])]
    public function index(
        BandRepository $bandRepository,
        PaginatorInterface $paginator,
        Request $request): Response
    {
        $filter = new BandFilter();
        $form = $this->createForm(BandFilterForm::class, $filter);
        $form->handleRequest($request);

        $pagination = $paginator->paginate(
            $bandRepository->getBandsQueryBuilder($filter),
            $request->query->getInt('page', 1), 10);

        return $this->render('admin/band/index.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView(),
        ]);
    }

    #[Route('/admin/band/show/{id}', name: 'app_admin_band_show', methods: ['GET'])]
    public function show(Band $band): Response
    {
        return $this->render('admin/band/show.html.twig', [
            'band' => $band
        ]);
    }

    #[Route('/admin/band/new', name: 'app_admin_band_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $band = new Band();
        $form = $this->createForm(BandForm::class, $band);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($band);
            $entityManager->flush();

            $this->addFlash('success', 'Band was successfully created.');

            return $this->redirectToRoute('app_admin_band');
        }

        return $this->render('admin/band/new.html.twig', [
            'form' => $form->createView(),
            'buttonText' => 'Create'
        ]);
    }

    #[Route('/admin/band/edit/{id}', name: 'app_admin_band_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, Band $band): Response
    {
        $form = $this->createForm(BandForm::class, $band);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Band was successfully updated.');

            return $this->redirectToRoute('app_admin_band');
        }

        return $this->render('admin/band/new.html.twig', [
            'form' => $form->createView(),
            'band' => $band,
            'buttonText' => 'Update'
        ]);
    }

    #[Route('/admin/band/delete/{id}', name: 'app_admin_band_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, Band$band): Response
    {
        if ($this->isCsrfTokenValid('delete' . $band->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($band);
            $entityManager->flush();

            $this->addFlash('success', 'Band was successfully deleted.');
        }

        return $this->redirectToRoute('app_admin_band');
    }
}
