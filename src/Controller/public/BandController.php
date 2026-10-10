<?php

namespace App\Controller\public;

use App\Entity\Band;
use App\Filter\BandFilter;
use App\Form\BandFilterForm;
use App\Repository\BandRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BandController extends AbstractController
{
    #[Route('/band', name: 'app_band')]
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

        return $this->render('public/band/index.html.twig', [
            'pagination' => $pagination,
            'filterForm' => $form->createView(),
        ]);
    }

    #[Route('/band/show/{id}', name: 'app_band_show')]
    public function show(Band $band): Response
    {
        return $this->render('public/band/show.html.twig', [
            'band' => $band,
        ]);
    }
}
