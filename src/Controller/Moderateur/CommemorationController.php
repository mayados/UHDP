<?php

namespace App\Controller\Moderateur;

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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


#[IsGranted('ROLE_MODERATEUR_COMMEMORATION', statusCode: 403, message: 'Il faut être modérateur pour accéder à la messagerie')]
class CommemorationController extends AbstractController
{

    #[Route('/moderateur/commemoration/mots', name: 'app_moderateur_commemoration_mots')]
    public function findMotsNonSignales(MotCommemorationRepository $mcr, ManagerRegistry $doctrine, Request $request): Response
    {

        return $this->render('moderateur/mur_commemoration/mots.html.twig', [
            'mots' => $mcr->findPaginatedNonSignales($request->query->getInt('page',1)),
        ]);  

    }

    #[Route('/moderateur/commemoration/mots/signales', name: 'app_moderateur_commemoration_mots_signales')]
    public function findMotsSignales(ReportMotRepository $rmr, ManagerRegistry $doctrine, Request $request): Response
    {

        return $this->render('moderateur/mur_commemoration/mots_signales.html.twig', [
            'mots' => $rmr->findPaginatedSignales($request->query->getInt('page',1)),
        ]);  

    }

    #[Route('/moderateur/commemoration/mot/{id}', name: 'app_moderateur_mot_show')]
    public function showMot(MotCommemoration $mot, Request $request, ManagerRegistry $doctrine): Response
    {

        return $this->render('moderateur/mur_commemoration/showMot.html.twig', [
            'mot' => $mot,
        ]); 
    }

    #[Route('/moderateur/commemoration/remove/mot/{id}', name: 'app_moderateur_mot_remove')]
    public function removeMot(MotCommemorationRepository $mcr, MotCommemoration $mot)
    {

        $mot = $mcr->find($mot->getId());        
        $mcr->remove($mot, $flush = true);

        $this->addFlash('success', "Le mot a été supprimé");

        return $this->redirectToRoute('app_moderateur_commemoration_mots_signales');            

    }

    #[Route('/moderateur/commemoration/reports/remove/{id}', name: 'app_moderateur_mot_remove_reports')]
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
            'app_moderateur_mot_show',
            ['id' => $mot->getId()]
        );          

    }
    
}