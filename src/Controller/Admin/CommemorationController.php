<?php

namespace App\Controller\Admin;

use App\Form\CategorieType;
use App\Entity\CategorieAnimal;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CategorieAnimalRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\MotCommemorationRepository;
use App\Repository\ReportMotRepository;
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
    
}