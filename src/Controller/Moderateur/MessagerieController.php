<?php

namespace App\Controller\Moderateur;

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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


#[IsGranted('ROLE_MODERATEUR_COMMEMORATION', statusCode: 403, message: 'Il faut être modérateur pour accéder à la messagerie')]
class MessagerieController extends AbstractController
{

    /* Messages signalés */
    #[Route('/moderateur/messagerie/signales', name: 'app_moderateur_messagerie_signales')]
    public function findReported(MessageRepository $mr, Request $request): Response
    {
        return $this->render('moderateur/messagerie/messages_signales.html.twig', [
            'messagesSignales' => $mr->findPaginatedSignales($request->query->getInt('page',1)),
        ]); 
    }

    #[Route('/moderateur/message/{id}', name: 'app_moderateur_message_show')]
    public function showMot(Message $message, Request $request, ManagerRegistry $doctrine): Response
    {

        return $this->render('moderateur/messagerie/showMessage.html.twig', [
            'message' => $message,
        ]); 
    }    

    #[Route('/moderateur/message/remove/{id}', name: 'app_moderateur_message_remove')]
    public function removeMessage(MessageRepository $mr, Message $message)
    {

        $message = $mr->find($message->getId());        
        $mr->remove($message, $flush = true);

        $this->addFlash('success', "Le message a été supprimé");

        return $this->redirectToRoute('app_moderateur_messagerie_signales');            

    }

    #[Route('/moderateur/message/report/remove/{id}', name: 'app_moderateur_message_report_remove')]
    public function removeReportMessage(MessageRepository $mr, Message $message, ManagerRegistry $doctrine)
    {

        $entityManager = $doctrine->getManager();
        $message = $mr->find($message->getId());
        $message->setIsSignaled(false);
        $entityManager->persist($message);        
        $entityManager->flush();

        $this->addFlash('success', "Le signalement a été supprimé");

        return $this->redirectToRoute('app_moderateur_messagerie_signales');        

    }
    
}