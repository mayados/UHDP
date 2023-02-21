<?php

namespace App\Controller;

use App\Repository\AnimalMemorialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(AnimalMemorialRepository $amr): Response
    {
        $derniersMemoriaux = $amr->findBy([],['dateCreation' => 'DESC'],3);

        return $this->render('home/index.html.twig', [
            'derniersMemoriaux' => $derniersMemoriaux,
        ]);
    }
}
