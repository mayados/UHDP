<?php

namespace App\Controller;

use App\Repository\AnimalMemorialRepository;
use App\Repository\BelleHistoireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(AnimalMemorialRepository $amr, BelleHistoireRepository $bhr): Response
    {
        $derniersMemoriaux = $amr->findBy([],['dateCreation' => 'DESC'],4);
        $dernieresHistoires = $bhr->findBy([],['dateCreation' => 'DESC'],4);

        return $this->render('home/index.html.twig', [
            'derniersMemoriaux' => $derniersMemoriaux,
            'dernieresHistoires' => $dernieresHistoires,
        ]);
    }
}
