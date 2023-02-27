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
        // Renvoie une erreur 400 : acces denied si le user qui tente d'y accéder n'a pas le rôle admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
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
        // Il faut être connecté pour accéder à son profil ou à la page de profil d'un utilisateur
        if($this->getUser()){
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

        // Si le user n'est pas connecté, on dirige vers la page de login
        return $this->redirectToRoute('app_login'); 

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
