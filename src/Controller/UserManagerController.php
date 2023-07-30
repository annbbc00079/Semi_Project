<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
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

class UserManagerController extends AbstractController
{
    public function __construct(private UrlGeneratorInterface $url)
    {      
    }
    #[Route('/user/manager/add', name: 'app_user_manager_add')]
    public function usermanager(Request $req, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $em): Response
    {
        $u = new User();
        $form = $this->createForm(UserFormType::class, $u);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $u = $form->getData();
            // encode the plain password
            $u->setPassword(
                $userPasswordHasher->hashPassword(
                    $u,
                    $form->get('password')->getData()
                )
            );

            $u -> setRoles(["ROLE_ADMIN"]);
            $em->persist($u);
            $em->flush();
            // do anything else you need here, like send an email

            return new RedirectResponse($this->url->generate('app_user_manager'));
        }

        return $this->render('user_manager/index.html.twig', [
            'u_form' => $form->createView(),
        ]);
    }
    #[Route('/user/manager', name: 'app_user_manager')]
    public function index(EntityManagerInterface $em): Response
    {
        $query = $em->createQuery('SELECT u FROM App\Entity\User u');
        $lUser = $query->getResult();
        
        return $this->render('user_manager/list.html.twig', [
            'data' => $lUser
        ]);
    }
   
    #[Route('/user/manager/{id}/delete', name: 'app_delete_user_manager')]
    public function deleteu(EntityManagerInterface $em, int $id,Request $req): Response
    {
        $u = $em->find(User::class, $id);
        $em->remove($u);
        $em->flush();
        return new RedirectResponse($this->url->generate('app_user_manager'));
    }
}
