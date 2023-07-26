<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;



class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_ds_san_pham');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    #[Route('/register/ds', name: 'app_ds_register')]
    public function list_rg(EntityManagerInterface $em): Response
    {
        $query = $em->createQuery('SELECT user FROM App\Entity\User user');
        $lSp = $query->getResult();
        return $this->render('registration/list.html.twig',[
            'data' => $lSp
        ]);

    }
    #[Route('/register/{id}', name: 'app_edit_register')]
    public function edit(EntityManagerInterface $em, int $id,Request $req,FileUploader $fileUploader): Response
    {
        $user = $em->find(User::class, $id);
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form -> handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            
            
            
            $user->setUsername($data->setUsername())->setPassword($data->setPassword())->setFirstName($data->setFirstName())->setLastName($data->setLastName());
            $em->flush();
            return new RedirectResponse($this->urlGenerator->generate('app_ds_register'));
        }
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    #[Route('/register/{id}/delete', name: 'app_delete_register')]
    public function deleteuser(EntityManagerInterface $em, int $id,Request $req): Response
    {
        $user = $em->find(User::class, $id);
        $em->remove($user);
        $em->flush();
        return new RedirectResponse($this->urlGenerator->generate('app_ds_register'));
    }
}
