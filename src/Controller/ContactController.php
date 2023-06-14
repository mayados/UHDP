<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {

        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);



        if($form->isSubmitted() && $form->isValid()){

            $data = $form->getData();

            if($data['email'] ==null){
                $adresse = $data['hnp'];

                $contenu = $data['content'];

                $email = (new Email())
                    ->from($adresse)
                    ->to('contact@uhdp')
                    ->subject('Demande de contact')
                    ->text($contenu);

                $mailer->send($email);

                $this->addFlash('success', 'Votre message a bien été envoyé');

                return $this->redirectToRoute('app_contact');                
            }

            $this->addFlash('notice', "Impossible d'envoyer le message");

            return $this->redirectToRoute('app_contact');     

        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
