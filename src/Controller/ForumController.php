<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Topic;
use App\Form\TopicType;
use App\Repository\TopicRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ForumController extends AbstractController
{
    #[Route('/forum', name: 'app_forum')]
    public function index(TopicRepository $tr): Response
    {

        $topics = $tr->findBy([],['dateCreation' => 'ASC']);
        
        return $this->render('forum/index.html.twig', [
            'topics' => $topics,
        ]);
    }

    #[Route('/forum/add', name: 'add_topic')]
    #[Route('/forum/edit/{id}', name: 'edit_topic')]
    public function add(ManagerRegistry $doctrine, Topic $topic = null, Request $request): Response
    {

        $edit = false;
        if($topic){
            $edit = true;
            $date = $topic->getDateCreation();
            /* Nous ciblons le premier post de la collection de posts de l'entité Topic, car il correspond au message de l'auteur
            et qu'il faudra le modifier dans le cadre d'un edit, et non créer un autre post */
            $post = $topic->getPosts()[0];
            
        }else{
            $topic = new Topic();
            $date = new \DateTime();    
            $post = new Post();                    
        }
        // dd($topic->getPosts()[0]->getTexte());

        $form = $this->createForm(TopicType::class, $topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $topic = $form->getData();   
            $firstComment = $form->get('firstComment')->getData();
            $auteurTopic = $form->get('auteur')->getData();
            $post->setTexte($firstComment);
            $post->setAuteur($auteurTopic);
            $post->setTopic($topic);
            $post->setDateCreation($date);
            $topic->addPost($post);
            $topic->setDateCreation($date); 
            $topic->setVerrouillage(0);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($topic);
            $entityManager->flush();


            return $this->redirectToRoute('app_forum');
        }

        return $this->render('forum/add.html.twig', [
            'formAddTopic' => $form->createView(),
            'edit' => $topic->getId(),
            'post' => $post,
        ]);

    }
}
