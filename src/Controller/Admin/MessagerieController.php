<?php

namespace App\Controller\Admin;

use App\Form\CategorieType;
use App\Entity\CategorieAnimal;
use App\Repository\MessageRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CategorieAnimalRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessagerieController extends AbstractController
{

    /* Messages signalés */
    #[Route('/admin/messagerie/signales', name: 'app_admin_messagerie_signales')]
    public function findReported(MessageRepository $mr, Request $request): Response
    {
        return $this->render('admin/messagerie/messages_signales.html.twig', [
            'messagesSignales' => $mr->findPaginatedSignales($request->query->getInt('page',1)),
        ]); 
    }
    
}