<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/admin/users', name: 'app_users')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll()
        ]);
    }


    #[Route('/admin/user/{id}/to/editor', name: 'app_user_to_editor')]
    public function addEditorRole(EntityManagerInterface $em, User $user): Response
    {
        $user->setRoles(["ROLE_EDITOR", "ROLE_USER"]);
        $em->flush();
        $this->addFlash("success", "the editor role has been added to the user" );
return $this->redirectToRoute('app_users');

    }


    #[Route('/admin/user/{id}/remove/editor', name: 'app_user_remove_editor')]
    public function removeEditorRole(EntityManagerInterface $em, User $user): Response
    {
        $user->setRoles([]);
        $em->flush();
        $this->addFlash("success", "the editor role has been removed from user" );
return $this->redirectToRoute('app_users');

    }



    #[Route('/admin/user/{id}/remove', name: 'app_user_remove')]
    public function removeUser(EntityManagerInterface $em, $id,UserRepository $userRepository): Response
    {
        $currentUser = $userRepository->find($id);
        $em->remove($currentUser);
        $em->flush();
        $this->addFlash("success", "User deleted successfully" );
return $this->redirectToRoute('app_users');

    }

}