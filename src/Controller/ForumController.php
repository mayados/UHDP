<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Topic;
use App\Form\PostType;
use App\Form\TopicType;
use App\Repository\PostRepository;
use App\Repository\TopicRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ForumController extends AbstractController
{
    #[Route('/forum', name: 'app_forum')]
    public function index(TopicRepository $tr): Response
    {

        if($this->getUser()){
            $topics = $tr->findBy([],['dateCreation' => 'DESC']);
            
            return $this->render('forum/index.html.twig', [
                'topics' => $topics,
            ]);            
        }

        return $this->render('forum/nonConnecte.html.twig');       

    }

    #[Route('/topic/{id}', name: 'show_topic')]
    public function showTopic(ManagerRegistry $doctrine, TopicRepository $tr, Topic $topic, Request $request): Response
    {
        if($this->getUser()){
            $topic = $tr->find($topic->getId());

            // Si l'utilisateur est connecté et vérifié
            if ($this->getUser()->isVerified() === true) {
                $post = new Post();
                $date = new \DateTime();
                $form = $this->createForm(PostType::class, $post);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $post = $form->getData();
                    $post->setAuteur($this->getUser());
                    $post->setTopic($topic);
                    $post->setDateCreation($date);
                    $topic->addPost($post);
                    $entityManager = $doctrine->getManager();
                    $entityManager->persist($post);
                    $entityManager->flush();

                    return $this->redirectToRoute(
                        'show_topic',
                        ['id' => $topic->getId()]
                    );
                }

                return $this->render('forum/topic.html.twig', [
                    'topic' => $topic,
                    'formAddPost' => $form->createView(),
                ]);
            }

            // S'il y a un utilisateur et qu'il n'est pas vérifié on renvoie à la vue sans le form du post
            return $this->render('forum/topic.html.twig', [
                'topic' => $topic,
            ]);            
        }

        // Si le user n'est pas connecté on redirige vers le login car il n'a pas le droit d'accès à cette page
        return $this->redirectToRoute('app_login');

    }

    #[Route('/forum/add', name: 'add_topic')]
    #[Route('/forum/edit/{id}', name: 'edit_topic')]
    public function add(ManagerRegistry $doctrine, Topic $topic = null, Request $request): Response
    {

        // Il faut être un utilisateur connecté pour accéder à l'edit ou à la création
        if($this->getUser()){
            $edit = false;
            // CAS  de l'edit => Si le topic existe ET que l'utilisateur connecté est l'auteur du topic OU que l'utilisateur a le rôle admin...
            if($topic && ($this->getUser() == $topic->getAuteur() || $this->getUser()->getRoles()['0'] == "ROLE_ADMIN")){
                $edit = true;
                $date = $topic->getDateCreation();
                /* Nous ciblons le premier post de la collection de posts de l'entité Topic, car il correspond au message de l'auteur
                et qu'il faudra le modifier dans le cadre d'un edit, et non créer un autre post */
                $post = $topic->getPosts()[0];
                // Dans le cas d'un edit, on attribue à auteur la value de l'auteur du topic stockée en base de données (car si c'est un admin qui modifie, ce ne sera pas l'auteur)
                $auteurTopic = $topic->getAuteur();
            // CAS de la création => Si le topic n'existe pas ET que l'utilisateur courant est vérifié
            }elseif(!$topic && $this->getUser()->isVerified()){
                $topic = new Topic();
                $date = new \DateTime();    
                $post = new Post();   
                $auteurTopic = $this->getUser();                                 
            }else{
                // Si l'utilisateur courant ne correspond à aucun critère ci-dessus on redirige vers le login
                return $this->redirectToRoute('app_login');
            }
            // dd($topic->getPosts()[0]->getTexte());

            $form = $this->createForm(TopicType::class, $topic);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $topic = $form->getData();   
                $firstComment = $form->get('firstComment')->getData();
                $post->setTexte($firstComment);
                $post->setAuteur($auteurTopic);
                $post->setTopic($topic);
                $post->setDateCreation($date);
                $topic->addPost($post);
                $topic->setAuteur($auteurTopic);
                $topic->setDateCreation($date); 
                $topic->setVerrouillage(0);
                $entityManager = $doctrine->getManager();
                $entityManager->persist($topic);
                $entityManager->flush();


                return $this->redirectToRoute('app_forum');
            }

            return $this->render('forum/add.html.twig', [
                'formAddTopic' => $form->createView(),
                'edit' => $edit,
                'post' => $post,
            ]);            
        }
        // Si l'utilisateur courant n'est pas connecté on redirige vers le login
        return $this->redirectToRoute('app_login');

    }

    #[Route('/topic/remove/{id}', name: 'remove_topic')]
    public function removeTopic(TopicRepository $tr, Topic $topic)
    {
        $topic = $tr->find($topic->getId());
        $tr->remove($topic, $flush = true);

        return $this->redirectToRoute('app_forum');
    }

    #[Route('/post/remove/{idTopic}/{id}', name: 'remove_post')]
    #[ParamConverter("topic", options: ["mapping" => ["idTopic" => "id"]])]
    #[ParamConverter("post", options: ["mapping" => ["id" => "id"]])]
    public function removePost(PostRepository $pr, Post $post, Topic $topic)
    {
        $post = $pr->find($post->getId());
        $topic = $topic->getId();
        $pr->remove($post, $flush = true);

        return $this->redirectToRoute(
            'show_topic',
            ['id' => $topic]
        );
    }

    #[Route('/topic/verrouillage/{id}', name: 'verrouillage_topic')]
    public function verrouillageTopic(Topic $topic, TopicRepository $tr, ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $topic = $tr->find($topic->getId());
        // On vérifie s'il s'agit d'un verrouillage ou dévérouillage
        if($topic->isVerrouillage() == false){
            // On vérrouille le topic
            $topic->setVerrouillage(true);
        }else{
            // On déverouille
            $topic->setVerrouillage(false);
        }

        $entityManager->flush();

        return $this->redirectToRoute(
            'show_topic',
            ['id' => $topic->getId()]
        );
    }

}
