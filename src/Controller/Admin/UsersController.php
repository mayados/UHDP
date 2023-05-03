<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\AddUserType;
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
    public function showUser(User $user, ManagerRegistry $doctrine, Request $request,UserPasswordHasherInterface $userPasswordHasher,): Response
    {

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


            return $this->redirectToRoute('app_admin_users_show');
        }

        return $this->render('admin/utilisateurs/showUser.html.twig', [
            'formAddUser' => $form->createView(),
            'user' => $user,
        ]);
    }

}