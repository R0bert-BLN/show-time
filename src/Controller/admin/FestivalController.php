<?php

namespace App\Controller\admin;

use App\Entity\Festival;
use App\Filter\FestivalFilter;
use App\Form\CreateFestivalForm;
use App\Form\FestivalFilterForm;
use App\Repository\FestivalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FestivalController extends AbstractController
{
    #[Route('/admin/festival', name: 'app_admin_festival', methods: ['GET'])]
    public function index(
        FestivalRepository $festivalRepository,
        PaginatorInterface $paginator,
        Request $request): Response
    {
        $filter = new FestivalFilter();
        $form = $this->createForm(FestivalFilterForm::class, $filter);
        $form->handleRequest($request);

        $pagination = $paginator->paginate(
            $festivalRepository->getFestivalsQueryBuilder($filter),
            $request->query->getInt('page', 1), 10);

        return $this->render('/admin/festival/index.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView(),
        ]);
    }

    #[Route('/admin/festival/show/{id}', name: 'app_admin_festival_show', methods: ['GET'])]
    public function show(Festival $festival): Response
    {
        return $this->render('admin/festival/show.html.twig', [
            'festival' => $festival
        ]);
    }

    #[Route('admin/festival/new', name: 'app_admin_festival_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $festival = new Festival();
        $form = $this->createForm(CreateFestivalForm::class, $festival);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($festival->getBands() as $band) {
                $band->setFestival($festival);
            }

            $entityManager->persist($festival);
            $entityManager->flush();
            $this->addFlash('success', 'Festival was successfully created.');

            return $this->redirectToRoute('app_admin_festival');
        }

        return $this->render('admin/festival/new.html.twig', [
            'form' => $form->createView(),
            'buttonText' => 'Create',
        ]);
    }

    #[Route('admin/festival/edit/{id}', name: 'app_admin_festival_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, Festival $festival): Response
    {
        $form = $this->createForm(CreateFestivalForm::class, $festival);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($festival->getBands() as $band) {
                $band->setFestival($festival);
            }

            $entityManager->flush();
            $this->addFlash('success', 'Festival was successfully updated.');

            return $this->redirectToRoute('app_admin_festival');
        }

        return $this->render('admin/festival/new.html.twig', [
            'form' => $form->createView(),
            'buttonText' => 'Update',
        ]);
    }

    #[Route('/admin/festival/delete/{id}', name: 'app_admin_festival_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, Festival $festival): Response
    {
        if ($this->isCsrfTokenValid('delete' . $festival->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($festival);
            $entityManager->flush();

            $this->addFlash('success', 'Festival was successfully deleted.');
        }

        return $this->redirectToRoute('app_admin_festival');
    }
}
