<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Entity\Topic;
use App\Form\PostType;
use App\Form\TopicType;
use App\Form\CategorieType;
use App\Entity\CategorieAnimal;
use App\Repository\PostRepository;
use App\Repository\TopicRepository;
use App\Repository\ReportPostRepository;
use App\Repository\ReportTopicRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CategorieAnimalRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ForumController extends AbstractController
{

    /* Topics non signalés*/
    #[Route('/admin/forum/topics', name: 'app_admin_topics')]
    public function findTopics(TopicRepository $tr, Request $request): Response
    {
        return $this->render('admin/forum/topics.html.twig', [
            'topics' => $tr->findPaginatedTopicsNonSignales($request->query->getInt('page',1)),
        ]); 
    }

    /* Topics signalés */
    #[Route('/admin/forum/topics/signales', name: 'app_admin_topics_signales')]
    public function findTopicsDeverrouilles(TopicRepository $tr, ReportTopicRepository $rpr, Request $request): Response
    {
        return $this->render('admin/forum/topics_signales.html.twig', [
            'topicsSignales' => $rpr->findPaginatedTopicsSignales($request->query->getInt('page',1)),
        ]); 
    }

    /* Posts */
    #[Route('/admin/forum/posts', name: 'app_admin_forum_posts')]
    public function findPosts(PostRepository $pr, ManagerRegistry $doctrine, Request $request): Response
    {

        return $this->render('admin/forum/posts.html.twig', [
            'posts' => $pr->findPaginatedPostsNonSignales($request->query->getInt('page',1)),
        ]);  

    }

    #[Route('/admin/forum/posts/signales', name: 'app_admin_forum_posts_signales')]
    public function findPostsSignales(ReportPostRepository $rpr, ManagerRegistry $doctrine, Request $request): Response
    {

        return $this->render('admin/forum/posts_signales.html.twig', [
            'postsSignales' => $rpr->findPaginatedPostsSignales($request->query->getInt('page',1)),
        ]);  

    }

    #[Route('/admin/forum/topic/{slug}', name: 'app_admin_forum_topic_show')]
    public function showTopic(Topic $topic, PostRepository $pr, Request $request,ManagerRegistry $doctrine): Response
    {

        $idTopic = $topic->getId();
        $firstPost = $pr->findFirstPost($idTopic);
        $post = $topic->getPosts()[0];

        $form = $this->createForm(TopicType::class, $topic);
        $form->handleRequest($request);
        $date = $topic->getDateCreation();

        if ($form->isSubmitted() && $form->isValid()) {
            $topic = $form->getData();            
            $topic->setDateCreation($date);
            $first = $form->get('firstComment')->getData() ;
            $post->setTexte($first);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($topic);
            $entityManager->flush();

            return $this->redirectToRoute(
                'app_admin_forum_topic_show',
                ['slug' => $topic->getSlug()]
            );   
           
        }

        return $this->render('admin/forum/showTopic.html.twig', [
            'topic' => $topic,
            'firstPost' => $firstPost,
            'formEditTopic' => $form->createView(),
        ]);  

    }

    #[Route('/admin/forum/post/{id}', name: 'app_admin_forum_post_show')]
    public function showPost(Post $post, Request $request,ManagerRegistry $doctrine): Response
    {

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        $topic = $post->getTopic();
        $date = $post->getDateCreation();
        $auteur = $post->getAuteur();

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post->setAuteur($auteur);
            $post->setTopic($topic);
            $post->setDateCreation($date);
            // $topic->addPost($post);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute(
                'app_admin_forum_post_show',
                ['id' => $post->getId()]
            );
        }

        return $this->render('admin/forum/showPost.html.twig', [
            'post' => $post,
            'formEditPost' => $form->createView(),
        ]);  

    }

    #[Route('/admin/forum/post/remove/{id}', name: 'app_admin_post_remove', requirements: ['id' => '\d+'])]
    public function removePost(PostRepository $pr, Post $post)
    {

            $pr->remove($post, $flush = true);
            

            $this->addFlash('notice', 'Le commentaire a été supprimé');

            return $this->redirectToRoute(
                'app_admin_forum_posts_signales'
            );
    }    

    #[Route('admin/forum/topic/remove/{slug}', name: 'app_admin_topic_remove')]
    public function removeTopic(TopicRepository $tr, Topic $topic)
    {

            $topic = $tr->find($topic->getId());
            $tr->remove($topic, $flush = true);

            $this->addFlash('notice', 'Le topic a été supprimé');

            return $this->redirectToRoute('app_admin_topics_signales');            
    }

}