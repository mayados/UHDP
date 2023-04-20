<?php

namespace App\Controller\Admin;

use App\Form\CategorieType;
use App\Entity\CategorieAnimal;
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
    public function posts(MotCommemorationRepository $mcr, ManagerRegistry $doctrine, Request $request): Response
    {

        $mots = $mcr->findAll();

        return $this->render('admin/mur_commemoration/mots.html.twig', [
            'mots' => $mots,
        ]);  

    }
    
}