<?php

namespace App\Controller\Admin;

use App\Form\MotType;
use App\Form\CategorieType;
use App\Entity\CategorieAnimal;
use App\Entity\MotCommemoration;
use App\Repository\ReportMotRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CategorieAnimalRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\MotCommemorationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommemorationController extends AbstractController
{

    #[Route('/admin/commemoration/mots', name: 'app_admin_commemoration_mots')]
    public function findMotsNonSignales(MotCommemorationRepository $mcr, ManagerRegistry $doctrine, Request $request): Response
    {

        return $this->render('admin/mur_commemoration/mots.html.twig', [
            'mots' => $mcr->findPaginatedNonSignales($request->query->getInt('page',1)),
        ]);  

    }

    #[Route('/admin/commemoration/mots/signales', name: 'app_admin_commemoration_mots_signales')]
    public function findMotsSignales(ReportMotRepository $rmr, ManagerRegistry $doctrine, Request $request): Response
    {

        return $this->render('admin/mur_commemoration/mots_signales.html.twig', [
            'mots' => $rmr->findPaginatedSignales($request->query->getInt('page',1)),
        ]);  

    }

    #[Route('/admin/commemoration/mot/{id}', name: 'app_admin_mot_show')]
    public function showMot(MotCommemoration $mot, Request $request, ManagerRegistry $doctrine): Response
    {

        $form = $this->createForm(MotType::class, $mot);  
        $form->handleRequest($request);
        $auteur = $mot->getAuteur();
        $date = $mot->getDateCreation();

        if($form->isSubmitted() && $form->isValid()) {
            $mot = $form->getData();            
                
            $mot->setAuteur($auteur);
            $mot->setDateCreation($date);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($mot);
            $entityManager->flush();

            $this->addFlash('success', "Le mot a été modifié avec succès");

            return $this->redirectToRoute(
                'app_admin_mot_show',
                ['id' => $mot->getId()]
            );
        }

        return $this->render('admin/mur_commemoration/showMot.html.twig', [
            'mot' => $mot,
            'formEditMot' => $form->createView(),
        ]); 
    }

    #[Route('/admin/commemoration/remove/mot/{id}', name: 'app_admin_mot_remove')]
    public function removeMot(MotCommemorationRepository $mcr, MotCommemoration $mot)
    {

        $mot = $mcr->find($mot->getId());        
        $mcr->remove($mot, $flush = true);

        $this->addFlash('success', "Le mot a été supprimé");

        return $this->redirectToRoute('app_admin_commemoration_mots_signales');            

    }

    #[Route('/admin/commemoration/reports/remove/{id}', name: 'app_admin_mot_remove_reports')]
    public function removeReportMots(ReportMotRepository $rmr, MotCommemoration $mot)
    {
        $idMot = $mot->getId();
        $reports = $rmr->findReportsByMot($idMot);

        foreach($reports as $report)
        {
            $rmr->remove($report, $flush = true);
        }

        $this->addFlash('notice', "Les signalements ont été supprimés");

        return $this->redirectToRoute(
            'app_admin_mot_show',
            ['id' => $mot->getId()]
        );          

    }
    
}