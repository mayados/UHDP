<?php

namespace App\Controller\Admin;

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

class MainController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }


    #[Route('/admin/categorie/remove/{id}', name: 'app_admin_remove_categorie')]
    public function removeCategorie(CategorieAnimalRepository $car, CategorieAnimal $categorie): Response
    {

        $categorie = $car->find($categorie->getId());    
        $car->remove($categorie, $flush = true);

        return $this->redirectToRoute('app_admin_categories');
    }

    
}
