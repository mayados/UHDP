<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\UploaderService;
use App\Repository\UserRepository;
use App\Repository\TopicRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BelleHistoireRepository;
use App\Repository\AnimalMemorialRepository;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/user/edit/{id}', name: 'edit_profile')]
    public function editProfile(User $user, UploaderService $uploaderService, Request $request, ManagerRegistry $doctrine)
    {

        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        if(!$this->getUser() === $user){
            return $this->redirectToRoute('app_home');
        }


        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {         
            $imgProfil = $form->get('photoProfil')->getData();
            if($imgProfil){
                // Si on est dans le cas d'un edit et qu'une nouvelle image est uploadée (car lors d'un ajout on ne va pas supprimer le fichier qu'ion crée..)
                if($user->getPhoto() != null){
                    $previousPhoto = $user->getPhoto();
                    $folder = 'imgUserProfil';
                    $uploaderService->delete($previousPhoto,$folder);
                }
                    // Dans le cas où il y a une image soumise mais que le profil n'a pas encore d'image (=> cas d'edit sans image)
                $folder = 'imgUserProfil';
                $image = $uploaderService->add($imgProfil,$folder);
                $user->setPhoto($image);                              
                }

                $entityManager = $doctrine->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute(
                    'show_profile',
                    ['id' => $user->getId()]
                );
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'formEditProfile' => $form->createView(),
        ]); 

    }

}
