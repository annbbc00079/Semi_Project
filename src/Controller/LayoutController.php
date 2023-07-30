<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LayoutController extends AbstractController
{
    #[Route('/layout', name: 'app_layout')]
    public function index(): Response
    {
        return $this->render('layout/index.html.twig', [
            'controller_name' => 'LayoutController',
        ]);
    }
}
