<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CategorieType;
use App\Entity\CategorieAnimal;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CategorieAnimalRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    // Montrer les catégories existantes et formulaire d'ajout de catégorie
    #[Route('/admin/categories', name: 'app_admin_categories')]
    public function categories(CategorieAnimalRepository $car, ManagerRegistry $doctrine, Request $request): Response
    {

        $categories = $car->findAll();

        // Créer une catégorie -> directement possible depuis la vue TWIG
        $categorie = new CategorieAnimal(); 
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid()) {
            $categorie = $form->getData();  
            $entityManager = $doctrine->getManager();
            $entityManager->persist($categorie);
            $entityManager->flush();                                  

            return $this->redirectToRoute(
                'app_admin_categories',
            );
        }

        return $this->render('admin/categories.html.twig', [
            'categories' => $categories,
            'formAddCategorie' => $form->createView(),
        ]);  

    }

    #[Route('/admin/categorie/remove/{id}', name: 'app_admin_remove_categorie')]
    public function removeCategorie(CategorieAnimalRepository $car, CategorieAnimal $categorie): Response
    {

        $categorie = $car->find($categorie->getId());    
        $car->remove($categorie, $flush = true);

        return $this->redirectToRoute('app_admin_categories');
    }

    #[Route('/admin/users', name: 'app_admin_users')]
    public function findUsers(UserRepository $ur): Response
    {
        $utilisateursBannis = $ur->findBannedUsersNotAdmin();
        $utilisateursNonBannis = $ur->findNotBannedUsersNotAdmin();

        return $this->render('admin/users.html.twig', [
            'utilisateursBannis' => $utilisateursBannis,
            'utilisateursNonBannis' => $utilisateursNonBannis,
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

        return $this->redirectToRoute(
            'show_profile',
            ['id' => $user->getId()]
        );
    }

    #[Route('/admin/memoriaux', name: 'admin_memoriaux')]
    public function findMemoriaux()
    {
        // Afficher les mémoriaux du plus recent au plus ancien
        // Afficher les mémoriaux dont l'auteur a été surppimé ? 
    }

    #[Route('/admin/topics', name: 'admin_topics')]
    public function findTopics()
    {
        // Afficher les Topics non vérrouillés du plus recent au plus ancien
        // Afficher les Topic vérouillés du plus récent au plus ancien 
    }

    #[Route('/admin/histoires', name: 'admin_histoires')]
    public function findHistoires()
    {
        // Afficher les histoires de la plus récente à la plus ancienne
    }

    #[Route('/admin/mur', name: 'admin_mur')]
    public function findMotsCommemoration()
    {
        // Afficher les mots de commémoration du plus récent au plus ancien
    }
    
}
