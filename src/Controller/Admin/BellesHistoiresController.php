<?php

namespace App\Controller\Admin;


use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BelleHistoireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BellesHistoiresController extends AbstractController
{

    /*  Histoires publiées */
    #[Route('/admin/histoires/publiees', name: 'app_admin_histoires_publiees')]
    public function findHistoiresPubliees(BelleHistoireRepository $bhr, Request $request): Response
    {
        return $this->render('admin/publiees.html.twig', [
            'histoiresPubliees' => $bhr->findPaginatedPubliees($request->query->getInt('page',1)),
        ]); 
    }


    /* Histoires en attente */
    #[Route('/admin/histoires/attente', name: 'app_admin_histoires_attente')]
    public function findHistoiresWaiting(BelleHistoireRepository $bhr, Request $request): Response
    {
        return $this->render('admin/en_attente.html.twig', [
            'histoiresWaiting' => $bhr->findPaginatedWaiting($request->query->getInt('page',1)),
        ]); 
    }


    /* Histoires désapprouvées */
    #[Route('/admin/histoires/desapprouvees', name: 'app_admin_histoires_desapprouvees')]
    public function findHistoiresDesapprouvees(BelleHistoireRepository $bhr, Request $request): Response
    {
        return $this->render('admin/desapprouvees.html.twig', [
            'histoiresDesapprouvees' => $bhr->findPaginatedDisapprouved($request->query->getInt('page',1)),
        ]); 
    }


    /* Liste des commentaires */


    /* Genres (+ possibilité d'ajout) */

}