<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserManagerController extends AbstractController
{
    #[Route('/user/manager', name: 'app_user_manager')]
    public function index(): Response
    {
        return $this->render('user_manager/index.html.twig', [
            'controller_name' => 'UserManagerController',
        ]);
    }
}
