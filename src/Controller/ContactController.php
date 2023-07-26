<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(EntityManagerInterface $em,Request $req, FileUploader $fileUploader): Response
    {
        $ct = new Contact();
        $form = $this->createForm(ContactType::class, $ct);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $em->persist($ct);
            $em->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_ds_contact');
        }
        return $this->render('contact/index.html.twig', [
            'contact_form' => $form->createView(),
        ]);
    }
    #[Route('/contact/ds', name: 'app_ds_contact')]
    public function list_ct(EntityManagerInterface $em): Response
    {
        $query = $em->createQuery('SELECT ct FROM App\Entity\Contact ct');
        $lSp = $query->getResult();
        return $this->render('contact/list.html.twig', [
            'data' => $lSp
        ]);

    }
    #[Route('/contact/{id}/delete', name: 'app_delete_contact')]
    public function deletect(EntityManagerInterface $em, int $id,Request $req): Response
    {
        $ct = $em->find(Contact::class, $id);
        $em->remove($ct);
        $em->flush();
        return new RedirectResponse($this->urlGenerator->generate('app_ds_contact'));
    }
}
