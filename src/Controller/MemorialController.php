<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemorialController extends AbstractController
{
    #[Route('/memorial', name: 'app_memorial')]
    public function index(): Response
    {
        return $this->render('memorial/index.html.twig', [
            'controller_name' => 'MemorialController',
        ]);
    }
}
