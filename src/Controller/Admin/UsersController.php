<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
}