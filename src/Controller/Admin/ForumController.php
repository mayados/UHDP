<?php

namespace App\Controller\Admin;

use App\Form\CategorieType;
use App\Entity\CategorieAnimal;
use App\Repository\PostRepository;
use App\Repository\TopicRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CategorieAnimalRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ForumController extends AbstractController
{

    /* Topics verouillés */
    #[Route('/admin/forum/topics/verrouilles', name: 'app_admin_topics_verrouilles')]
    public function findTopicsVerrouilles(TopicRepository $tr, Request $request): Response
    {
        return $this->render('admin/forum/topics_verrouilles.html.twig', [
            'topicsVerrouilles' => $tr->findPaginatedVerrouilles($request->query->getInt('page',1)),
        ]); 
    }

    /* Topics non verrouillés */
    #[Route('/admin/forum/topics/deverrouilles', name: 'app_admin_topics_deverrouilles')]
    public function findTopicsDeverrouilles(TopicRepository $tr, Request $request): Response
    {
        return $this->render('admin/forum/topics_deverrouilles.html.twig', [
            'topicsDeverrouilles' => $tr->findPaginatedDeverrouilles($request->query->getInt('page',1)),
        ]); 
    }

    /* Posts */
    #[Route('/admin/forum/posts', name: 'app_admin_forum_posts')]
    public function posts(PostRepository $pr, ManagerRegistry $doctrine, Request $request): Response
    {

        $posts = $pr->findAll();

        return $this->render('admin/forum/posts.html.twig', [
            'posts' => $posts,
        ]);  

    }

}