<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MotCommemorationController extends AbstractController
{
    #[Route('/mot/commemoration', name: 'app_mot_commemoration')]
    public function index(): Response
    {
        return $this->render('mot_commemoration/index.html.twig', [
            'controller_name' => 'MotCommemorationController',
        ]);
    }
}
