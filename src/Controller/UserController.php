<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AnimalMemorialRepository;
use App\Repository\BelleHistoireRepository;
use App\Repository\TopicRepository;
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

    #[Route('/user/{id}', name: 'show_profile')]
    public function showProfile(UserRepository $ur, User $user, AnimalMemorialRepository $amr, BelleHistoireRepository $bhr, TopicRepository $tr): Response
    {
        // Il faut être connecté pour accéder à son profil ou à la page de profil d'un utilisateur
        if($this->getUser()){
            // En fonction de si le user est le même que le current ou non, on affiche des render différents
            $user = $ur->find($user->getId());
            $memoriaux = $amr->findBy(['auteur' => $user],['dateCreation' => 'DESC']);               
            $histoires = $bhr->findBy(['auteur' => $user],['dateCreation' => 'DESC']);               
            $topics = $tr->findBy(['auteur' => $user],['dateCreation' => 'DESC']);               
            if($this->getUser() != $user){
              
                return $this->render('user/profil.html.twig', [
                    'user' => $user,
                    'memoriaux' => $memoriaux,
                    'histoires' => $histoires,
                    'topics' => $topics,
                ]);            
            }else{
                return $this->render('user/monProfil.html.twig', [
                    'user' => $user,
                    'memoriaux' => $memoriaux,
                    'histoires' => $histoires,
                    'topics' => $topics,
                ]); 
            }            
        }

        // Si le user n'est pas connecté, on dirige vers la page de login
        return $this->redirectToRoute('app_login'); 

    }

}
