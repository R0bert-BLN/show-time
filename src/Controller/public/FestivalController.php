<?php

namespace App\Controller\public;

use App\Entity\Festival;
use App\Filter\FestivalFilter;
use App\Form\FestivalFilterForm;
use App\Repository\FestivalRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FestivalController extends AbstractController
{
    #[Route('/festival', name: 'app_festival')]
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

        return $this->render('/public/festival/index.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView(),
        ]);
    }

    #[Route('/festival/show/{id}', name: 'app_festival_show', methods: ['GET'])]
    public function show(Festival $festival): Response
    {
        return $this->render('public/festival/show.html.twig', [
            'festival' => $festival
        ]);
    }
}
