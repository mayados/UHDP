<?php

namespace App\Controller\Moderateur;


use DateTimeZone;
use DateTimeImmutable;
use App\Form\HistoireType;
use App\Entity\BelleHistoire;
use App\Entity\GenreHistoire;
use App\Form\GenreHistoireType;
use App\Service\SluggerService;
use App\Service\UploaderService;
use App\Form\CommentHistoireType;
use App\Entity\CommentBelleHistoire;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BelleHistoireRepository;
use App\Repository\GenreHistoireRepository;
use App\Repository\ReportCommentRepository;
use App\Repository\ReportHistoireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommentBelleHistoireRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[IsGranted('ROLE_MODERATEUR_HISTOIRES', statusCode: 403, message: 'Il faut être modérateur pour accéder à cette page')]
class BellesHistoiresController extends AbstractController
{

    /*  Histoires publiées */
    #[Route('/moderateur/histoires/publiees', name: 'app_moderateur_histoires_publiees')]
    public function findHistoiresPubliees(BelleHistoireRepository $bhr, Request $request): Response
    {
        return $this->render('moderateur/belles_histoires/publiees.html.twig', [
            'histoiresPubliees' => $bhr->findPaginatedPublieesNonSignalees($request->query->getInt('page',1)),
        ]); 
    }


    /* Histoires en attente */
    #[Route('/moderateur/histoires/attente', name: 'app_moderateur_histoires_attente')]
    public function findHistoiresWaiting(BelleHistoireRepository $bhr, Request $request): Response
    {
        return $this->render('moderateur/belles_histoires/en_attente.html.twig', [
            'histoiresWaiting' => $bhr->findPaginatedWaiting($request->query->getInt('page',1)),
        ]); 
    }


    /* Histoires désapprouvées */
    #[Route('/moderateur/histoires/desapprouvees', name: 'app_moderateur_histoires_desapprouvees')]
    public function findHistoiresDesapprouvees(BelleHistoireRepository $bhr, Request $request): Response
    {
        return $this->render('moderateur/belles_histoires/desapprouvees.html.twig', [
            'histoiresDesapprouvees' => $bhr->findPaginatedDisapprouved($request->query->getInt('page',1)),
        ]); 
    }

    /*  Histoires signalées */
    #[Route('/moderateur/histoires/signalees', name: 'app_moderateur_histoires_signalees')]
    public function findHistoiresSignalees(ReportHistoireRepository $rhr, Request $request): Response
    {
        return $this->render('moderateur/belles_histoires/histoires_signalees.html.twig', [
            'histoiresSignalees' => $rhr->findPaginatedPublieesSignalees($request->query->getInt('page',1)),
        ]); 
    }

    /* Liste des commentaires */
    #[Route('/moderateur/histoires/commentaires', name: 'app_moderateur_histoires_commentaires')]
    public function findCommentairesNonSignales(CommentBelleHistoireRepository $cbhr, ManagerRegistry $doctrine, Request $request): Response
    {

        return $this->render('moderateur/belles_histoires/commentaires.html.twig', [
            'commentaires' => $cbhr->findPaginatedNonSignales($request->query->getInt('page',1)),
        ]);  

    }

    #[Route('/moderateur/histoires/commentaires/signales', name: 'app_moderateur_histoires_commentaires_signales')]
    public function findCommentairesSignales(ReportCommentRepository $rcr, ManagerRegistry $doctrine, Request $request): Response
    {

        return $this->render('moderateur/belles_histoires/commentaires_signales.html.twig', [
            'commentaires' => $rcr->findPaginatedSignales($request->query->getInt('page',1)),
        ]);  

    }

    #[Route('/moderateur/histoire/{slug}', name: 'app_moderateur_histoire_show')]
    public function showHistoire(BelleHistoire $histoire,BelleHistoireRepository $bhr, Request $request, UploaderService $uploaderService, ManagerRegistry $doctrine, SluggerService $sluggerService): Response
    {

        $form = $this->createForm(HistoireType::class, $histoire);  
        $form->handleRequest($request);
        $auteur = $histoire->getAuteur();
        $date = $histoire->getDateCreation();

        if($form->isSubmitted() && $form->isValid()) {
            $histoire = $form->getData();            
                
            $imgHistoire = $form->get('imgHistoire')->getData();
            $titre = $form->get('titre')->getData();
            $slug = $sluggerService->slugElement($titre);
            if($imgHistoire){
                // Si on est dans le cas d'un edit et qu'une nouvelle image est uploadée (car lors d'un ajout on ne va pas supprimer le fichier qu'ion crée..)
                if($histoire->getPhoto() != null){
                    // On cherche la photo stockée pour le mémorial correspondant
                    $previousPhoto = $histoire->getPhoto();
                    $folder = 'imgHistoire';
                    $uploaderService->delete($previousPhoto,$folder);
                }
                // Dans le cas où il y a une image soumise mais que le mémorial n'a pas encore d'image (=> cas d'ajout de mémorial ou edit sans image)
                $folder = 'imgHistoire';
                $image = $uploaderService->add($imgHistoire,$folder);
                $histoire->setPhoto($image);     
            }

            $histoire->setSlug($slug);
            $histoire->setAuteur($auteur);
            $histoire->setDateCreation($date); 
            // Dans tous les cas, on persist le memorial
            $entityManager = $doctrine->getManager();
            $entityManager->persist($histoire);
            $entityManager->flush();

            $this->addFlash('success', "L'histoire a été modifiée avec succès");

            return $this->redirectToRoute(
                'app_moderateur_histoire_show',
                ['slug' => $histoire->getSlug()]
            );
        }

        return $this->render('moderateur/belles_histoires/showHistoire.html.twig', [
            'histoire' => $histoire,
            'formEditHistoire' => $form->createView(),
        ]); 
    }

    #[Route('/moderateur/commentaire/{id}', name: 'app_moderateur_commentaire_show')]
    public function showCommentaire(CommentBelleHistoire $commentaire, CommentBelleHistoireRepository $cbhr, Request $request, ManagerRegistry $doctrine): Response
    {

        return $this->render('moderateur/belles_histoires/showCommentaire.html.twig', [
            'commentaire' => $commentaire,
            'formEditCommentaire' => $form->createView(),
        ]); 
    }

    #[Route('/moderateur/commentaire/remove/{id}', name: 'app_moderateur_comment_remove')]
    public function removeCommentaire(CommentBelleHistoireRepository $cbhr, CommentBelleHistoire $comment)
    {
        $comment = $cbhr->find($comment->getId());

        $cbhr->remove($comment, $flush = true);

        $this->addFlash('notice', "Le commentaire a été supprimé");

        return $this->redirectToRoute(
            'app_moderateur_histoires_commentaires_signales'
        );            
    }

    #[Route('/moderateur/histoire/disapprouved/{slug}', name: 'app_moderateur_histoire_disapprouved')]
    public function disapprouvedHistoire(BelleHistoire $histoire,BelleHistoireRepository $bhr, Request $request, ManagerRegistry $doctrine): Response
    {

        $entityManager = $doctrine->getManager();
        $histoire = $bhr->find($histoire->getId());
        $histoire->setEtat('STATE_DISAPPROUVED');
       $entityManager->persist($histoire);        
        $entityManager->flush();

        $this->addFlash('success', "L'histoire a été désapprouvée");

        return $this->redirectToRoute(
            'app_moderateur_histoire_show',
            ['slug' => $histoire->getSlug()]
        );
    
    }

    #[Route('/moderateur/histoire/approuved/{slug}', name: 'app_moderateur_histoire_approuved')]
    public function approuvedHistoire(BelleHistoire $histoire,BelleHistoireRepository $bhr, Request $request, ManagerRegistry $doctrine): Response
    {

        $now = new DateTimeImmutable(null, new DateTimeZone('Europe/Paris'));
        $entityManager = $doctrine->getManager();
        $histoire = $bhr->find($histoire->getId());
        $histoire->setEtat('STATE_APPROUVED');
        $histoire->setDatePublication($now);
        $entityManager->persist($histoire);        
        $entityManager->flush();

        $this->addFlash('success', "L'histoire a été approuvée");

        return $this->redirectToRoute(
            'app_moderateur_histoire_show',
            ['slug' => $histoire->getSlug()]
        );
    
    }


    #[Route('/moderateur/histoire/reports/remove/{id}', name: 'app_moderateur_histoire_remove_reports')]
    public function removeReportsHistoire(ReportHistoireRepository $rhr, BelleHistoire $histoire)
    {
        $idHistoire = $histoire->getId();
        $reports = $rhr->findReportsByHistoire($idHistoire);

        foreach($reports as $report)
        {
            $rhr->remove($report, $flush = true);
        }

        $this->addFlash('notice', "Les signalements ont été supprimés");

        return $this->redirectToRoute(
            'app_moderateur_histoire_show',
            ['slug' => $histoire->getSlug()]
        );          

    }

    #[Route('/moderateur/commentaire/reports/remove/{id}', name: 'app_moderateur_commentaire_remove_reports')]
    public function removeReportComments(ReportCommentRepository $rcr, CommentBelleHistoire $comment)
    {
        $idComment = $comment->getId();
        $reports = $rcr->findReportsByComment($idComment);

        foreach($reports as $report)
        {
            $rcr->remove($report, $flush = true);
        }

        $this->addFlash('notice', "Les signalements ont été supprimés");

        return $this->redirectToRoute(
            'app_moderateur_commentaire_show',
            ['id' => $comment->getId()]
        );          

    }


}