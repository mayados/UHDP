<?php

namespace App\Controller;

use App\Entity\AnimalMemorial;
use App\Entity\CategorieAnimal;
use App\Repository\AnimalMemorialRepository;
use App\Repository\CategorieAnimalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemorialController extends AbstractController
{
    #[Route('/memoriaux', name: 'app_memoriaux')]
    public function index(AnimalMemorialRepository $amr, CategorieAnimalRepository $car): Response
    {
        $listeMemoriaux = $amr->findAll();

        $categories = $car->findAll();

        return $this->render('memorial/listeMemoriaux.html.twig', [
            'listeMemoriaux' => $listeMemoriaux,
            'categories' => $categories,
        ]);
    }

    #[Route('/categorie/{id}', name: 'app_categorie')]
    public function memoriauxParCategorie(CategorieAnimalRepository $car, CategorieAnimal $categorie): Response
    {
        $categorie = $car->find($categorie->getId());

        return $this->render('memorial/listeParCategorie.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    #[Route('/memorial/{id}', name: 'show_memorial')]
    public function showMemorial(AnimalMemorialRepository $amr, AnimalMemorial $memorial): Response
    {
        $memorial = $amr->find($memorial->getId());

        return $this->render('memorial/memorial.html.twig', [
            'memorial' => $memorial,
        ]);
    }

    #[Route('/memorial/add', name: 'add_memorial')]
    public function add(): Response
    {

    }

}
