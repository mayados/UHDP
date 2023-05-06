<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Form\AddUserType;
use App\Form\UserPhotoType;
use App\Service\UploaderService;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersController extends AbstractController
{
    
    #[Route('/admin/users/bannis', name: 'app_admin_users_bannis')]
    public function findBannedUsers(UserRepository $ur, Request $request): Response
    {

        return $this->render('admin/utilisateurs/banned_users.html.twig', [
            'utilisateursBannis' => $ur->findBannedUsersNotAdmin($request->query->getInt('page',1)),
        ]);
    }
    

    #[Route('/admin/users/nonbannis', name: 'app_admin_users_unbanned')]
    public function findNonBannis(UserRepository $ur, Request $request): Response
    {

        return $this->render('admin/utilisateurs/non_bannis.html.twig', [
            'utilisateursNonBannis' => $ur->findNotBannedUsersNotAdmin($request->query->getInt('page',1)),
        ]);
    }

    #[Route('/admin/users/moderateurs', name: 'app_admin_moderateurs')]
    public function findModerateurs(UserRepository $ur, Request $request): Response
    {

        return $this->render('admin/utilisateurs/moderateurs.html.twig', [
            'moderateurs' => $ur->findModerateurs($request->query->getInt('page',1)),
        ]);
    }

    #[Route('/admin/users/add', name: 'app_admin_users_add')]
    public function addUser(ManagerRegistry $doctrine, Request $request,UserPasswordHasherInterface $userPasswordHasher,): Response
    {

        $user = new User();
        $form = $this->createForm(AddUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();            
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                $user,
                $form->get('plainPassword')->getData()
            ));
            $user->setBannir(false);
            $user->setIsVerified(true);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();


            return $this->redirectToRoute('app_admin_users_add');
        }

        return $this->render('admin/utilisateurs/addUser.html.twig', [
            'formAddUser' => $form->createView(),
        ]);
    }

    #[Route('/admin/users/show/{id}', name: 'app_admin_users_show')]
    public function showUser(User $user, ManagerRegistry $doctrine, Request $request,UserPasswordHasherInterface $userPasswordHasher,UploaderService $uploaderService): Response
    {

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $formPhoto = $this->createForm(UserPhotoType::class, $user);
        $formPhoto->handleRequest($request);
        $mail = $user->getEmail();

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();    
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();


            return $this->redirectToRoute(
                'app_admin_users_show',
                ['id' => $user->getId()]
            );   
        }

        if ($formPhoto->isSubmitted() && $formPhoto->isValid()) {
            $user = $formPhoto->getData();            
            $imgUser= $formPhoto->get('imgUser')->getData();
            if($imgUser){
                // Si on est dans le cas d'un edit et qu'une nouvelle image est uploadée (car lors d'un ajout on ne va pas supprimer le fichier qu'on crée..)
                if($user->getPhoto() != null){
                    // On cherche la photo stockée pour le mémorial correspondant
                    $previousPhoto = $user->getPhoto();

                    $folder = 'imgUserProfil';
                    $uploaderService->delete($previousPhoto,$folder);
                }
                // Dans le cas où il y a une image soumise mais que le mémorial n'a pas encore d'image (=> cas d'ajout de mémorial ou edit sans image)
                $folder = 'imgUserProfil';
                $image = $uploaderService->add($imgUser,$folder);
                $user->setPhoto($image);                              
            }
            // Dans tous les cas, on persist le memorial
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute(
                'app_admin_users_show',
                ['id' => $user->getId()]
            );   
        }

        return $this->render('admin/utilisateurs/showUser.html.twig', [
            'formAddUser' => $form->createView(),
            'user' => $user,
            'formPhoto' => $formPhoto->createView(),
        ]);
    }

    #[Route('/admin/user/ban/{id}', name: 'ban_admin_user')]
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

        // $this->addFlash('notice',"L'utilisateur a été banni");

        return $this->redirectToRoute(
            'app_admin_users_show',
            ['id' => $user->getId()]
        );   
    }

}