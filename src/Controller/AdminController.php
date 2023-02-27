<?php

namespace App\Controller;

use App\Entity\CategorieAnimal;
use App\Repository\CategorieAnimalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    // Montrer les catégories existantes et formulaire d'ajout de catégorie
    #[Route('/admin/categories', name: 'app_admin_categories')]
    public function categories(CategorieAnimalRepository $car): Response
    {

        $categories = $car->findAll();


        return $this->render('admin/categories.html.twig', [
            'categories' => $categories,
        ]);
    }


    #[Route('/admin/categorie/remove/{id}', name: 'app_admin_remove_categorie')]
    public function removeCategorie(CategorieAnimalRepository $car, CategorieAnimal $categorie): Response
    {

        $categorie = $car->find($categorie->getId());    
        $car->remove($categorie, $flush = true);

        return $this->redirectToRoute('app_admin_categories');
    }

    // Liste des utilisateurs (voir dans UserController)
}
