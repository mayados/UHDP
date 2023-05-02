<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Topic;
use App\Entity\ReportMot;
use App\Entity\ReportPost;
use App\Entity\Condoleance;
use App\Entity\ReportTopic;
use App\Entity\BelleHistoire;
use App\Entity\ReportComment;
use App\Entity\AnimalMemorial;
use App\Entity\ReportHistoire;
use App\Entity\ReportMemorial;
use App\Entity\MotCommemoration;
use App\Entity\ReportCondoleance;
use App\Entity\CommentBelleHistoire;
use App\Repository\ReportMotRepository;
use App\Repository\ReportPostRepository;
use App\Repository\ReportTopicRepository;
use App\Repository\ReportCommentRepository;
use App\Repository\ReportHistoireRepository;
use App\Repository\ReportMemorialRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ReportCondoleanceRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
class ReportController extends AbstractController
{
    #[Route('/report/memorial/{id}', name: 'app_report_memorial')]
    public function reportMemorial(AnimalMemorial $memorial, ReportMemorialRepository $rpm, Request $request): Response
    {
        
        $user = $this->getUser();

        $signaleur = $rpm->findSignaleurMemorial($user,$memorial);

        // Met la mauvaise heure : deux heures de moins que l'heure actuelle
        $now = new \DateTimeImmutable();

        if($signaleur != null){

            // dd($signaleur);
            $rpm->remove($signaleur, $flush = true);
            // Signifie que le user a déjà signalé ce mémorial, donc on dé-signal

        }else{
            $report = new ReportMemorial();
            $report->setSignaleur($user);
            $report->setMemorial($memorial);
            $report->setDateCreation($now);
            $rpm->save($report, $flush = true);
            // dd("Je suis null");
            // On crée un signalement
        }

        return $this->redirectToRoute(
            'show_memorial',
            ['id' => $memorial->getId()]
        );   
    }

    #[Route('/report/condoleance/{id}', name: 'app_report_condoleance')]
    public function reportCondoleance(Condoleance $condoleance, ReportCondoleanceRepository $rpc, Request $request): Response
    {
        
        $user = $this->getUser();

        $signaleur = $rpc->findSignaleurCondoleance($user,$condoleance);

        // Met la mauvaise heure : deux heures de moins que l'heure actuelle
        $now = new \DateTimeImmutable();

        if($signaleur != null){

            $rpc->remove($signaleur, $flush = true);

        }else{
            $report = new ReportCondoleance();
            $report->setSignaleur($user);
            $report->setCondoleance($condoleance);
            $report->setDateCreation($now);
            $rpc->save($report, $flush = true);
        }

        return $this->redirectToRoute(
            'show_memorial',
            ['id' => $condoleance->getMemorial()->getId()]
        );   
    }

    
    #[Route('/report/histoire/{id}', name: 'app_report_histoire')]
    public function reportHistoire(BelleHistoire $histoire, ReportHistoireRepository $rhr, Request $request): Response
    {
        
        $user = $this->getUser();

        $signaleur = $rhr->findSignaleurHistoire($user,$histoire);

        // Met la mauvaise heure : deux heures de moins que l'heure actuelle
        $now = new \DateTimeImmutable();

        if($signaleur != null){

            $rhr->remove($signaleur, $flush = true);

        }else{
            $report = new ReportHistoire();
            $report->setSignaleur($user);
            $report->setHistoire($histoire);
            $report->setDateCreation($now);
            $rhr->save($report, $flush = true);
        }

        return $this->redirectToRoute(
            'show_histoire',
            ['slug' => $histoire->getSlug()]
        );   
    }
    
    #[Route('/report/comment/{id}', name: 'app_report_comment')]
    public function reportComment(CommentBelleHistoire $comment, ReportCommentRepository $rcr, Request $request): Response
    {
        
        $user = $this->getUser();

        $signaleur = $rcr->findSignaleurHistoire($user,$comment);

        // Met la mauvaise heure : deux heures de moins que l'heure actuelle
        $now = new \DateTimeImmutable();

        if($signaleur != null){

            $rcr->remove($signaleur, $flush = true);

        }else{
            $report = new ReportComment();
            $report->setSignaleur($user);
            $report->setCommentaire($comment);
            $report->setDateCreation($now);
            $rcr->save($report, $flush = true);
        }

        return $this->redirectToRoute(
            'show_histoire',
            ['slug' => $comment->getBelleHistoire()->getSlug()]
        );   
    }

    #[Route('/report/topic/{id}', name: 'app_report_topic')]
    public function reportTopic(Topic $topic, ReportTopicRepository $rtr, Request $request): Response
    {
        
        $user = $this->getUser();

        $signaleur = $rtr->findSignaleurTopic($user,$topic);

        // Met la mauvaise heure : deux heures de moins que l'heure actuelle
        $now = new \DateTimeImmutable();

        if($signaleur != null){

            $rtr->remove($signaleur, $flush = true);

        }else{
            $report = new ReportTopic();
            $report->setSignaleur($user);
            $report->setTopic($topic);
            $report->setDateCreation($now);
            $rtr->save($report, $flush = true);
        }

        return $this->redirectToRoute(
            'show_topic',
            ['slug' => $topic->getSlug()]
        );   
    }

    #[Route('/report/post/{id}', name: 'app_report_post')]
    public function reportPost(Post $post, ReportPostRepository $rpr, Request $request): Response
    {
        
        $user = $this->getUser();

        $signaleur = $rpr->findSignaleurPost($user,$post);

        // Met la mauvaise heure : deux heures de moins que l'heure actuelle
        $now = new \DateTimeImmutable();

        if($signaleur != null){

            $rpr->remove($signaleur, $flush = true);

        }else{
            $report = new ReportPost();
            $report->setSignaleur($user);
            $report->setPost($post);
            $report->setDateCreation($now);
            $rpr->save($report, $flush = true);
        }

        return $this->redirectToRoute(
            'show_topic',
            ['slug' => $post->getTopic()->getSlug()]
        );   
    }
    
    #[Route('/report/mot/{id}', name: 'app_report_mot')]
    public function reportMot(MotCommemoration $mot, ReportMotRepository $rmr, Request $request): Response
    {
        
        $user = $this->getUser();

        $signaleur = $rmr->findSignaleurTopic($user,$mot);

        // Met la mauvaise heure : deux heures de moins que l'heure actuelle
        $now = new \DateTimeImmutable();

        if($signaleur != null){

            $rmr->remove($signaleur, $flush = true);

        }else{
            $report = new ReportMot();
            $report->setSignaleur($user);
            $report->setMot($mot);
            $report->setDateCreation($now);
            $rmr->save($report, $flush = true);
        }

        return $this->redirectToRoute(
            'app_mot_commemoration',
        );   
    }
}
