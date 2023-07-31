<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\SanPham;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }
    #[Route('/category', name: 'app_category')]
    public function index(EntityManagerInterface $em, Request $req, FileUploader $fileUploader): Response
    {
        $sp = new Category();
        $form = $this->createForm(CategoryType::class, $sp);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $file = $form->get("photo")->getData();
            $fileName = $fileUploader->upload($file);
            $data->setPhoto($fileName);

            $em->persist($data);
            $em->flush();
            return new RedirectResponse($this->urlGenerator->generate('app_category'));
        }

        return $this->render('category/index.html.twig', [
            'category_form' => $form->createView(),
        ]);
    }
    
}
