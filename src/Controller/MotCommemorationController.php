<?php

namespace App\Controller;

use App\Form\MotType;
use App\Entity\MotCommemoration;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\MotCommemorationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MotCommemorationController extends AbstractController
{
    #[Route('/mot/commemoration', name: 'app_mot_commemoration')]
    public function index(MotCommemorationRepository $mcr, ManagerRegistry $doctrine, Request $request): Response
    {
        // On trouve tous les mots par ordre décroissant pour afficher le dernier écrit au-dessus
        $mots = $mcr->findBy([],['dateCreation' => 'DESC']);

        // On veut afficher le formulaire pour ajouter un mot depuis cette même page
        $mot = new MotCommemoration();
        $date = new \DateTime();     
        $form = $this->createForm(MotType::class, $mot);
        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid()) {
            $mot = $form->getData();  
            $mot->setDateCreation($date);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($mot);
            $entityManager->flush();                                  

            return $this->redirectToRoute(
                'app_mot_commemoration',
            );
        }

        return $this->render('mot_commemoration/mur.html.twig', [
            'mots' => $mots,
            'formAddMot' => $form->createView(),
        ]);
    }

    #[Route('/mot/commemoration/remove/mot/{id}', name: 'remove_mot')]
    public function removeMot(MotCommemorationRepository $mcr, MotCommemoration $mot)
    {
        $mot = $mcr->find($mot->getId());
        $mcr->remove($mot, $flush = true);

        return $this->redirectToRoute('app_mot_commemoration');
    }

}
