<?php

namespace App\Controller\Admin;

use App\Form\CategorieType;
use App\Entity\CategorieAnimal;
use App\Repository\CondoleanceRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\AnimalMemorialRepository;
use App\Repository\CategorieAnimalRepository;
use App\Repository\ReportCondoleanceRepository;
use App\Repository\ReportMemorialRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MemoriauxController extends AbstractController
{

    /* Liste des mémoriaux */
    #[Route('/admin/memoriaux', name: 'app_admin_memoriaux')]
    public function findMemoriauxNonSignales(AnimalMemorialRepository $amr, Request $request): Response
    {

        return $this->render('admin/memoriaux/memoriaux.html.twig', [
            'memoriaux' => $amr->findPaginatedMemoriauxNonSignales($request->query->getInt('page',1)),
        ]);
    }

    /* Liste des mémoriaux signalés */
    #[Route('/admin/memoriaux/signales', name: 'app_admin_memoriaux_signales')]
    public function findMemoriauxSignales(ReportMemorialRepository $rmr, Request $request): Response
    {

        return $this->render('admin/memoriaux/memoriaux_signales.html.twig', [
            'memoriaux' => $rmr->findPaginatedSignales($request->query->getInt('page',1)),
        ]);
    }

    /* Liste des mots de condoléance */
    #[Route('/admin/memoriaux/condoleances', name: 'app_admin_condoleances')]
    public function findCondoleancesNonSignalees(CondoleanceRepository $cr, Request $request): Response
    {

        return $this->render('admin/memoriaux/condoleances.html.twig', [
            'condoleances' => $cr->findPaginatedCondoleancesNonSignalees($request->query->getInt('page',1)),
        ]);
    }

    #[Route('/admin/memoriaux/condoleances/signalees', name: 'app_admin_condoleances_signalees')]
    public function findCondoleancesSignalees(ReportCondoleanceRepository $rcr, Request $request): Response
    {

        return $this->render('admin/memoriaux/condoleances.html.twig', [
            'condoleances' => $rcr->findPaginatedSignalees($request->query->getInt('page',1)),
        ]);
    }

    /* Liste des catégories d'animaux + possibilité d'ajouter une catégorie */
    #[Route('/admin/memoriaux/categories', name: 'app_admin_categories')]
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

        return $this->render('admin/memoriaux/categories.html.twig', [
            'categories' => $categories,
            'formAddCategorie' => $form->createView(),
        ]);  

    }

    #[Route('/admin/memoriaux/{id}', name: 'app_admin_memorial_show')]
    public function showMemorial(AnimalMemorial $memorial, Request $request): Response
    {

        return $this->render('admin/memoriaux/showMemorial.html.twig', [
            'memorial' => $memorial,
        ]);
    }
}
