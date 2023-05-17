<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RefugeController extends AbstractController
{
    #[Route('/refuge', name: 'app_refuge')]
    public function index(): Response
    {
        return $this->render('refuge/index.html.twig', [
            'controller_name' => 'RefugeController',
        ]);
    }
}
