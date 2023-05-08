<?php

namespace App\Controller\Moderateur;

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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


#[IsGranted('ROLE_MODERATEUR_FORUM', statusCode: 403, message: 'Il faut être modérateur pour accéder à la messagerie')]
class ForumController extends AbstractController
{

    /* Topics non signalés*/
    #[Route('/moderateur/forum/topics', name: 'app_moderateur_topics')]
    public function findTopics(TopicRepository $tr, Request $request): Response
    {
        return $this->render('admin/forum/topics.html.twig', [
            'topics' => $tr->findPaginatedTopicsNonSignales($request->query->getInt('page',1)),
        ]); 
    }

    /* Topics signalés */
    #[Route('/moderateur/forum/topics/signales', name: 'app_moderateur_topics_signales')]
    public function findTopicsDeverrouilles(TopicRepository $tr, ReportTopicRepository $rpr, Request $request): Response
    {
        return $this->render('moderateur/forum/topics_signales.html.twig', [
            'topicsSignales' => $rpr->findPaginatedTopicsSignales($request->query->getInt('page',1)),
        ]); 
    }

    /* Posts */
    #[Route('/moderateur/forum/posts', name: 'app_moderateur_forum_posts')]
    public function findPosts(PostRepository $pr, ManagerRegistry $doctrine, Request $request): Response
    {

        return $this->render('moderateur/forum/posts.html.twig', [
            'posts' => $pr->findPaginatedPostsNonSignales($request->query->getInt('page',1)),
        ]);  

    }

    #[Route('/moderateur/forum/posts/signales', name: 'app_moderateur_forum_posts_signales')]
    public function findPostsSignales(ReportPostRepository $rpr, ManagerRegistry $doctrine, Request $request): Response
    {

        return $this->render('moderateur/forum/posts_signales.html.twig', [
            'postsSignales' => $rpr->findPaginatedPostsSignales($request->query->getInt('page',1)),
        ]);  

    }

    #[Route('/moderateur/forum/topic/{slug}', name: 'app_moderateur_forum_topic_show')]
    public function showTopic(Topic $topic, PostRepository $pr, Request $request,ManagerRegistry $doctrine): Response
    {

        $idTopic = $topic->getId();
        $firstPost = $pr->findFirstPost($idTopic);
        $post = $topic->getPosts()[0];

        return $this->render('moderateur/forum/showTopic.html.twig', [
            'topic' => $topic,
            'firstPost' => $firstPost,
        ]);  

    }

    #[Route('/moderateur/forum/post/{id}', name: 'app_moderateur_forum_post_show')]
    public function showPost(Post $post, Request $request,ManagerRegistry $doctrine): Response
    {

        return $this->render('moderateur/forum/showPost.html.twig', [
            'post' => $post,
        ]);  

    }

    #[Route('/moderateur/forum/post/remove/{id}', name: 'app_moderateur_post_remove', requirements: ['id' => '\d+'])]
    public function removePost(PostRepository $pr, Post $post)
    {

            $pr->remove($post, $flush = true);
            

            $this->addFlash('notice', 'Le commentaire a été supprimé');

            return $this->redirectToRoute(
                'app_moderateur_forum_posts_signales'
            );
    }    

    #[Route('moderateur/forum/topic/remove/{slug}', name: 'app_moderateur_topic_remove')]
    public function removeTopic(TopicRepository $tr, Topic $topic)
    {

            $topic = $tr->find($topic->getId());
            $tr->remove($topic, $flush = true);

            $this->addFlash('notice', 'Le topic a été supprimé');

            return $this->redirectToRoute('app_admin_topics_signales');            
    }

    #[Route('/moderateur/forum/topic/reports/remove/{id}', name: 'app_moderateur_topic_remove_reports')]
    public function removeReportsTopic(ReportTopicRepository $rtr, Topic $topic)
    {
        $idTopic = $topic->getId();
        $reports = $rtr->findReportsByTopic($idTopic);

        foreach($reports as $report)
        {
            $rtr->remove($report, $flush = true);
        }

        $this->addFlash('notice', "Les signalements ont été supprimés");

        return $this->redirectToRoute(
            'app_moderateur_forum_topic_show',
            ['slug' => $topic->getSlug()]
        );          

    }

    #[Route('/moderateur/forum/post/reports/remove/{id}', name: 'app_moderateur_post_remove_reports')]
    public function removeReportsPost(ReportPostRepository $rpr, Post $post)
    {
        $idPost = $post->getId();
        $reports = $rpr->findReportsByPost($idPost);

        foreach($reports as $report)
        {
            $rpr->remove($report, $flush = true);
        }

        $this->addFlash('notice', "Les signalements ont été supprimés");

        return $this->redirectToRoute(
            'app_moderateur_forum_post_show',
            ['id' => $post->getId()]
        );          

    }

}