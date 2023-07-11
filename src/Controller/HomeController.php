<?php

namespace App\Controller;

use App\Repository\AnimalMemorialRepository;
use App\Repository\BelleHistoireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(AnimalMemorialRepository $amr, BelleHistoireRepository $bhr): Response
    {
        $derniersMemoriaux = $amr->findBy([],['dateCreation' => 'DESC'],4);
        $dernieresHistoires = $bhr->findLastHistoires();
        $description = "Une histoire de pattes, votre cimetière virtuel pour animaux et espace d'entraide face au deuil";

        return $this->render('home/index.html.twig', [
            'derniersMemoriaux' => $derniersMemoriaux,
            'dernieresHistoires' => $dernieresHistoires,
            'description' => $description,
        ]);
    }

    #[Route('/notre/histoire', name: 'app_notre_histoire')]
    public function showNotreHistoire()
    {

        return $this->render('notreHistoire/notreHistoire.html.twig');
    }

}
