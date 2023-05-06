<?php

namespace App\Controller\Admin;

use App\Entity\Message;
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

    #[Route('/admin/message/{id}', name: 'app_admin_message_show')]
    public function showMot(Message $message, Request $request, ManagerRegistry $doctrine): Response
    {

        return $this->render('admin/messagerie/showMessage.html.twig', [
            'message' => $message,
        ]); 
    }    

    #[Route('/admin/message/remove/{id}', name: 'app_admin_message_remove')]
    public function removeMessage(MessageRepository $mr, Message $message)
    {

        $message = $mr->find($message->getId());        
        $mr->remove($message, $flush = true);

        $this->addFlash('success', "Le message a été supprimé");

        return $this->redirectToRoute('app_admin_messagerie_signales');            

    }

    #[Route('/admin/message/report/remove/{id}', name: 'app_admin_message_report_remove')]
    public function removeReportMessage(MessageRepository $mr, Message $message, ManagerRegistry $doctrine)
    {

        $entityManager = $doctrine->getManager();
        $message = $mr->find($message->getId());
        $message->setIsSignaled(false);
        $entityManager->persist($message);        
        $entityManager->flush();

        $this->addFlash('success', "Le signalement a été supprimé");

        return $this->redirectToRoute('app_admin_messagerie_signales');        

    }
    
}