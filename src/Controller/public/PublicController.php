<?php

namespace App\Controller\public;

use App\Repository\FestivalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PublicController extends AbstractController
{
    #[Route('/', name: 'app_show-time')]
    public function index(FestivalRepository $festivalRepository): Response
    {
        return $this->render('public/index.html.twig', [
            'festivals' => $festivalRepository->findTopFestivals(),
        ]);
    }
}
