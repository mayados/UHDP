<?php

namespace App\Controller\Admin;


use App\Entity\GenreHistoire;
use App\Form\GenreHistoireType;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BelleHistoireRepository;
use App\Repository\GenreHistoireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommentBelleHistoireRepository;
use App\Repository\ReportCommentRepository;
use App\Repository\ReportHistoireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BellesHistoiresController extends AbstractController
{

    /*  Histoires publiées */
    #[Route('/admin/histoires/publiees', name: 'app_admin_histoires_publiees')]
    public function findHistoiresPubliees(BelleHistoireRepository $bhr, Request $request): Response
    {
        return $this->render('admin/belles_histoires/publiees.html.twig', [
            'histoiresPubliees' => $bhr->findPaginatedPublieesNonSignalees($request->query->getInt('page',1)),
        ]); 
    }


    /* Histoires en attente */
    #[Route('/admin/histoires/attente', name: 'app_admin_histoires_attente')]
    public function findHistoiresWaiting(BelleHistoireRepository $bhr, Request $request): Response
    {
        return $this->render('admin/belles_histoires/en_attente.html.twig', [
            'histoiresWaiting' => $bhr->findPaginatedWaiting($request->query->getInt('page',1)),
        ]); 
    }


    /* Histoires désapprouvées */
    #[Route('/admin/histoires/desapprouvees', name: 'app_admin_histoires_desapprouvees')]
    public function findHistoiresDesapprouvees(BelleHistoireRepository $bhr, Request $request): Response
    {
        return $this->render('admin/belles_histoires/desapprouvees.html.twig', [
            'histoiresDesapprouvees' => $bhr->findPaginatedDisapprouved($request->query->getInt('page',1)),
        ]); 
    }

    /*  Histoires signalées */
    #[Route('/admin/histoires/signalees', name: 'app_admin_histoires_signalees')]
    public function findHistoiresSignalees(ReportHistoireRepository $rhr, Request $request): Response
    {
        return $this->render('admin/belles_histoires/histoires_signalees.html.twig', [
            'histoiresSignalees' => $rhr->findPaginatedPublieesSignalees($request->query->getInt('page',1)),
        ]); 
    }

    /* Liste des commentaires */
    #[Route('/admin/histoires/commentaires', name: 'app_admin_histoires_commentaires')]
    public function findCommentairesNonSignales(CommentBelleHistoireRepository $cbhr, ManagerRegistry $doctrine, Request $request): Response
    {

        return $this->render('admin/belles_histoires/commentaires.html.twig', [
            'commentaires' => $cbhr->findPaginatedNonSignales($request->query->getInt('page',1)),
        ]);  

    }

    #[Route('/admin/histoires/commentaires/signales', name: 'app_admin_histoires_commentaires_signales')]
    public function findCommentairesSignales(ReportCommentRepository $rcr, ManagerRegistry $doctrine, Request $request): Response
    {

        return $this->render('admin/belles_histoires/commentaires_signales.html.twig', [
            'commentaires' => $rcr->findPaginatedSignales($request->query->getInt('page',1)),
        ]);  

    }


    /* Genres (+ possibilité d'ajout) */
    #[Route('/admin/histoires/genres', name: 'app_admin_histoires_genres')]
    public function genres(GenreHistoireRepository $ghr, ManagerRegistry $doctrine, Request $request): Response
    {

        $genres = $ghr->findAll();

        // Créer un genre -> directement possible depuis la vue TWIG
        $genre = new GenreHistoire(); 
        $form = $this->createForm(GenreHistoireType::class, $genre);
        /* On intercepte la requête */
        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid()) {
            $genre = $form->getData();  
            $entityManager = $doctrine->getManager();
            $entityManager->persist($genre);
            $entityManager->flush();                                  

            return $this->redirectToRoute(
                'app_admin_histoires_genres',
            );
        }

        return $this->render('admin/belles_histoires/genres.html.twig', [
            'genres' => $genres,
            'formAddGenre' => $form->createView(),
        ]);  

    }


}