<?php

namespace App\Controller\admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StaffController extends AbstractController
{
    #[Route('/admin/staff', name: 'app_admin_staff')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/staff/index.html.twig');
    }
}
