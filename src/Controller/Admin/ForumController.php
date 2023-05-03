<?php

namespace App\Controller\Admin;

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

}