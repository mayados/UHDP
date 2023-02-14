<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BelleHistoireController extends AbstractController
{
    #[Route('/belle/histoire', name: 'app_belle_histoire')]
    public function index(): Response
    {
        return $this->render('belle_histoire/index.html.twig', [
            'controller_name' => 'BelleHistoireController',
        ]);
    }
}
