<?php

namespace App\Controller\Moderateur;

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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

#[Security("is_granted('ROLE_MODERATEUR_HISTOIRES') or is_granted('ROLE_MODERATEUR_FORUM') or is_granted('ROLE_MODERATEUR_MEMORIAUX') or is_granted('ROLE_MODERATEUR_COMMEMORATION')", statusCode: 403)]
class UsersController extends AbstractController
{
    
    #[Route('/moderateur/users/bannis', name: 'app_moderateur_users_bannis')]
    public function findBannedUsers(UserRepository $ur, Request $request): Response
    {

        return $this->render('moderateur/utilisateurs/banned_users.html.twig', [
            'utilisateursBannis' => $ur->findBannedUsersNotAdmin($request->query->getInt('page',1)),
        ]);
    }
    

    #[Route('/moderateur/users/nonbannis', name: 'app_moderateur_users_unbanned')]
    public function findNonBannis(UserRepository $ur, Request $request): Response
    {

        return $this->render('moderateur/utilisateurs/non_bannis.html.twig', [
            'utilisateursNonBannis' => $ur->findNotBannedUsersNotAdmin($request->query->getInt('page',1)),
        ]);
    }

    #[Route('/moderateur/users/show/{id}', name: 'app_moderateur_users_show')]
    public function showUser(User $user, ManagerRegistry $doctrine, Request $request,UserPasswordHasherInterface $userPasswordHasher,UploaderService $uploaderService): Response
    {

        return $this->render('moderateur/utilisateurs/showUser.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/moderateur/user/ban/{id}', name: 'ban_moderateur_user')]
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
            'app_moderateur_users_show',
            ['id' => $user->getId()]
        );   
    }

}