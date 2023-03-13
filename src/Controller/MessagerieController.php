<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessagerieController extends AbstractController
{
    #[Route('/messagerie', name: 'app_messagerie')]
    public function index(ManagerRegistry $doctrine, Request $request, MessageRepository $mr): Response
    {

        $user = $this->getUser();
        $conversations = $mr->findConversations($user);

        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message = $form->getData();
            $message->setExpediteur($this->getUser());
            $message->setIsRead(false);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute(
                'app_messagerie');
        }

        return $this->render('messagerie/index.html.twig', [
            'form' => $form->createView(),
            'conversations' => $conversations
        ]);
    }

    #[Route('/conversation/{id}', name: 'app_messagerie')]
    public function showConversation(ManagerRegistry $doctrine, Request $request, MessageRepository $mr): Response
    {


    }
}
