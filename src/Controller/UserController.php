<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserPhotoType;
use App\Service\UploaderService;
use App\Form\UserEditPasswordType;
use App\Repository\UserRepository;
use App\Repository\TopicRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BelleHistoireRepository;
use App\Repository\AnimalMemorialRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    // On accède juste à une page d'affichage d'informations, donc ici on peut passer l'id du user = donnée sensible (car on ne peut rien faire de mal dans l'url avec cette route)
    // Requirements ici sert à ce que le paramètre entré soit obligatoirement un digit
    #[Route('/user/{id}', name: 'show_profile', requirements: ['id' => '\d+'])]
    #[Security("is_granted('ROLE_USER')")]
    public function showProfile(UserRepository $ur, User $user, AnimalMemorialRepository $amr, BelleHistoireRepository $bhr, TopicRepository $tr): Response
    {

        $user = $ur->find($user->getId());
        $memoriaux = $amr->findBy(['auteur' => $user],['dateCreation' => 'DESC']);               
        $histoires = $bhr->findBy(['auteur' => $user],['dateCreation' => 'DESC']);               
        $topics = $tr->findBy(['auteur' => $user],['dateCreation' => 'DESC']);               
              
        return $this->render('user/profil.html.twig', [
            'user' => $user,
            'memoriaux' => $memoriaux,
            'histoires' => $histoires,
            'topics' => $topics,
        ]);            
    }

    #[Route('/monProfil', name: 'my_profile')]
    #[Security("is_granted('ROLE_USER')")]
    public function showMyProfile(AnimalMemorialRepository $amr, BelleHistoireRepository $bhr, TopicRepository $tr)
    {
        $user = $this->getUser();

        $memoriaux = $amr->findBy(['auteur' => $user],['dateCreation' => 'DESC']);               
        // $histoires = $bhr->findBy(['auteur' => $user],['dateCreation' => 'DESC']);
        $histoiresWaiting = $bhr->findMyWaitings($user);               
        $histoiresDraft = $bhr->findMyDrafts($user);               
        $histoiresApprouved = $bhr->findMyApprouved($user);               
        $histoiresDisapprouved = $bhr->findMyDisapprouved($user);                     
        $topics = $tr->findBy(['auteur' => $user],['dateCreation' => 'DESC']);  

        return $this->render('user/monProfil.html.twig', [
            'user' => $user,
            'memoriaux' => $memoriaux,
            // 'histoires' => $histoires,
            'histoiresWaiting' => $histoiresWaiting,
            'histoiresDraft' => $histoiresDraft,
            'histoiresApprouved' => $histoiresApprouved,
            'histoiresDisapprouved' => $histoiresDisapprouved,
            'topics' => $topics,
        ]); 

    }

    #[Route('/mesHistoires', name: 'my_histoires')]
    #[Security("is_granted('ROLE_USER')")]
    public function showMyHistoires(BelleHistoireRepository $bhr, Request $request): Response
    {

        $user = $this->getUser();
         
        $histoiresWaiting = $bhr->findMyWaitings($user);               
        $histoiresDraft = $bhr->findMyDrafts($user);               
        $histoiresApprouved = $bhr->findMyApprouved($user);               
        $histoiresDisapprouved = $bhr->findMyDisapprouved($user);               


        return $this->render('user/mesHistoires.html.twig', [
            'user' => $user,
            'histoiresWaiting' => $histoiresWaiting,
            'histoiresDraft' => $histoiresDraft,
            'histoiresApprouved' => $histoiresApprouved,
            'histoiresDisapprouved' => $histoiresDisapprouved
        ]); 

    }


    #[Route('/user/parametres', name: 'edit_profile')]
    #[Security("is_granted('ROLE_USER')")]
    public function editProfile(UploaderService $uploaderService, Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $hasher)
    {

        $user = $this->getUser();

        $form = $this->createForm(UserPhotoType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {         
            $imgProfil = $form->get('imgUser')->getData();
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

                $this->addFlash('success','Votre image de profil a bien été modifiée');

                return $this->redirectToRoute('edit_profile',);
        }

        $formPassword = $this->createForm(UserEditPasswordType::class);
        $formPassword->handleRequest($request);

        if ($formPassword->isSubmitted() && $formPassword->isValid()) {   
              
            // On vérifie si le mot de passe courant renseigné dans le formulaire correspond avec le mot de passe hashé du user (ici grâce à une méthode du UserPasswordHasherInterface) 
            if($hasher->isPasswordValid($user, $formPassword->get('currentPassword')->getData())){
       
                // On attribue au USER le nouveau mot de passe (sur le champ Password présent dans l'entité) ET on le hache tout de suite également
                $user->setPassword(
                        // On hash le password : 2 arguments => Le user dont le password doit être hashé + le password à hasher
                        $hasher->hashPassword(
                            $user,
                            $formPassword->get('newPassword')->getData(),
                        )
                );
                // On met à jour l'entité dans la bdd
                $entityManager = $doctrine->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'Votre mot de passe a bien été modifié');

                return $this->redirectToRoute(
                    'show_profile',
                    ['id' => $user->getId()]
                );

            }else{
                // Si le mot de passe courant entré n'est pas valide, on envoie un message flash
                $this->addFlash(
                    'warning',
                    'Le mot de passe entré est incorrect'
                );
            }

        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'formEditProfile' => $form->createView(),
            'formEditPassword' => $formPassword->createView(),
        ]); 

    }

    #[Route('/user/delete/account', name: 'suppr_account_user')]
    #[Security("is_granted('ROLE_USER')")]
    public function deleteUserAccount(UserRepository $ur, UploaderService $uploaderService, Request $request)
    {

        // Supprimer le compte et toutes les infos associées puis mise en place de l'anonymisation dans les vues
        $user = $this->getUser();
        // Avant de supprimer le user, il faut supprimer la photo associée dans le dossier concerné
        $photo = $user->getPhoto();
        if(!$photo == null){
            $folder = 'imgUserProfil';
            $uploaderService->delete($photo, $folder);            
        }

        // dd($user);
        // Il faut invalider la session et mettre le token à 0, comme ça Symfony ne cherche pas à rediriger l'utilisateur supprimé avec un id
        $request->getSession()->invalidate();
        $this->container->get('security.token_storage')->setToken(null);
        $ur->remove($user, $flush = true);

        $this->addFlash('notice','Votre compte a été supprimé');

        return $this->redirectToRoute('app_logout');
    }

}
