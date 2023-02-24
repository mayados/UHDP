<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/users', name: 'app_users')]
    public function findUsers(UserRepository $ur): Response
    {
        $utilisateursBannis = $ur->findBannedUsersNotAdmin();
        $utilisateursNonBannis = $ur->findNotBannedUsersNotAdmin();

        return $this->render('admin/users.html.twig', [
            'utilisateursBannis' => $utilisateursBannis,
            'utilisateursNonBannis' => $utilisateursNonBannis,
        ]);
    }

    #[Route('/user/{id}', name: 'show_profile')]
    public function showProfile(UserRepository $ur, User $user): Response
    {

        // En fonction de si le user est le même que le current ou non, on affiche des render différents
        $user = $ur->find($user->getId());
        if($this->getUser() != $user){
            return $this->render('user/profil.html.twig', [
                'user' => $user,
            ]);            
        }else{
            return $this->render('user/monProfil.html.twig', [
                'user' => $user,
            ]); 
        }

    }

    #[Route('/user/ban/{id}', name: 'ban_user')]
    public function banUser(User $user, UserRepository $ur, ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $user = $ur->find($user->getId());
        // On vérifie s'il s'agit d'un bannissement ou débannissement
        if($user->isBannir() == false){
            // On ban
            $user->setBannir(true);
        }else{
            // On dé-ban
            $user->setBannir(false);
        }

        $entityManager->flush();

        return $this->redirectToRoute(
            'show_profile',
            ['id' => $user->getId()]
        );
    }

}
