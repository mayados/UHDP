<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\UserRepository;
use App\Repository\MessageRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


#[IsGranted('ROLE_USER', statusCode: 404, message: 'Il faut être connecté pour accéder à la messagerie')]
class MessagerieController extends AbstractController
{

    #[Route('/messagerie', name: 'app_messagerie')]
    public function index(ManagerRegistry $doctrine, Request $request, MessageRepository $mr): Response
    {
        if($this->getUser()){
            $user = $this->getUser();

            $messagesNonLus = $mr->findUnreadMessages($user);

            return $this->render('messagerie/index.html.twig', [

                'messagesNonLus' => $messagesNonLus,
            ]);            
        }

        $this->addFlash('warning', 'Il faut être connecté pour accéder à la messagerie');
        return $this->redirectToRoute('app_login'); 
    }

    #[Route('/messagerie/nonClasses', name: 'app_nonClasses')]
    public function findNonClasses(ManagerRegistry $doctrine, Request $request, MessageRepository $mr): Response
    {
        if($this->getUser()){
            $user = $this->getUser();

            $nonClasses = $mr->findConversationsNonClassees($user);

            return $this->render('messagerie/nonClasses.html.twig', [

                'nonClasses' => $nonClasses,
            ]);            
        }

        $this->addFlash('warning', 'Il faut être connecté pour accéder à la messagerie');
        return $this->redirectToRoute('app_login'); 
    }

    #[Route('/messagerie/correspondants', name: 'app_correspondants')]
    public function findCorrespondants(ManagerRegistry $doctrine, Request $request, MessageRepository $mr): Response
    {
        if($this->getUser()){
            $user = $this->getUser();

            $correspondants = $mr->findCorrespondants($user);

            return $this->render('messagerie/correspondants.html.twig', [

                'correspondants' => $correspondants,
            ]);            
        }

        $this->addFlash('warning', 'Il faut être connecté pour accéder à la messagerie');
        return $this->redirectToRoute('app_login'); 
    }

    #[Route('/messagerie/signal/{id}', name: 'message_signal', requirements:['id' => '\d+'])]
    public function signalMessage(ManagerRegistry $doctrine, Request $request, MessageRepository $mr, Message $message): Response
    {
        // Il faudra faire en sorte que l'utilisateur ne puisse pas signaler son propre message

        $message->setIsSignaled(true);
        $entityManager = $doctrine->getManager();
        $entityManager->persist($message);
        $entityManager->flush();   

        $expediteur =$message->getExpediteur()->getId();

        $this->addFlash('success', 'Le message a été signalé');
        return $this->redirectToRoute('app_conversation',
        ['id' => $expediteur]); 
    }

    // Requirements pour spécifier que l'on attend un digit
    #[Route('/messagerie/conversation/{id}', name: 'app_conversation', requirements:['id' => '\d+'])]
    public function showConversation(ManagerRegistry $doctrine, Request $request, MessageRepository $mr, User $user, UserRepository $ur): Response
    {

        // Gérer le cas de redirection quand le User essaie d'aller à une conversation avec lui-même = pour qu'il ne s'écrive pas


        if($this->getUser()){
            $user = $ur->find($user->getId());
            $me = $this->getUser();
            $messages = $mr->findMessagesByConversation($me,$user);
            // Lorsque l'on va sur la conversation, on note tous les messages en lu
            foreach($messages as $message){
                if($message->getDestinataire() === $me){
                    $message->setIsRead(1);
                    $entityManager = $doctrine->getManager();
                    $entityManager->persist($message);
                    $entityManager->flush();                
                }
            }

            $message = new Message();
            $form = $this->createForm(MessageType::class, $message);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $message = $form->getData();
                $message->setExpediteur($this->getUser());
                $message->setDestinataire($user);
                $message->setIsRead(false);
                $entityManager = $doctrine->getManager();
                $entityManager->persist($message);
                $entityManager->flush();

                if($request->isXmlHttpRequest()){
                    // Si c'est le cas on renvoie du JSON
                    return new JsonResponse([
                        'content' => $this->renderView('_partials/_messages.html.twig', ['form' => $form->createView(), 'messages' => $mr->findMessagesByConversation($me,$user)]),

                    ]);
                }

                return $this->redirectToRoute(
                    'app_conversation',
                    ['id' => $user->getId()]
                );
            }

            return $this->render('messagerie/conversation.html.twig', [
                'form' => $form->createView(),
                'messages' => $messages,
                'user' => $user,
            ]);
        }

        $this->addFlash('warning', 'Il faut être connecté pour accéder à la messagerie');
        return $this->redirectToRoute('app_login'); 

    }

    // Utiliser le paramConverter
    #[Route('/messagerie/remove/{idConversation}/{id}', name: 'remove_message', requirements:['id' => '\d+'])]
    #[ParamConverter("user", options: ["mapping" => ["idConversation" => "id"]])]
    #[ParamConverter("message", options: ["mapping" => ["id" => "id"]])]
    public function deleteMessage(ManagerRegistry $doctrine, Request $request, User $user, MessageRepository $mr,Message $message, UserRepository $ur): Response
    {

        if($this->getUser() && ($this->getUser() == $message->getExpediteur()))
        {
            $user = $ur->find($user->getId());
            // On trouve l'id du message et on le delete grâce à la méthode du User
            $message = $mr->find($message->getId());

            // On doit obtenir doctrine
            $entityManager = $doctrine->getManager();
    
            $current = $ur->find($this->getUser());
            // On aura besoin de doctrine, car les choses vont changer en bdd
            $current->removeMessagesEnvoye($message, $flush = true);
            $entityManager->flush();

            $this->addFlash('notice', 'Le message a été supprimé');

            return $this->redirectToRoute(
                'app_conversation',
                ['id' => $user->getId()]
            );            
        }

        $this->addFlash('warning', 'Il faut être connecté pour accéder à la messagerie');
        return $this->redirectToRoute('app_login'); 
    }
}
