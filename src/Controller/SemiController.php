<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SemiController extends AbstractController
{
    #[Route('/semi', name: 'app_semi')]
    public function index(): Response
    {
        return $this->render('semi/index.html.twig', [
            'controller_name' => 'SemiController',
        ]);
    }

    #[Route('/binhphuong', name: 'index_binhphuong')]
    public function req(Request $req):Response
    {
        $a = $req->query->get('a');
        $at2 = $a * $a;
        return $this->render('tests/index.html.twig', [
            'a' => $at2,
        ]);
    }
}
