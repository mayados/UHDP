<?php

namespace App\Controller\Admin;


use DateTimeZone;
use App\Form\HistoireType;
use App\Entity\BelleHistoire;
use App\Entity\GenreHistoire;
use DateTimeImmutable;
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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BellesHistoiresController extends AbstractController
{

    /*  Histoires publiées */
    #[Route('/admin/histoires/publiees', name: 'app_admin_histoires_publiees')]
    public function findHistoiresPubliees(BelleHistoireRepository $bhr, Request $request): Response
    {
        return $this->render('admin/belles_histoires/publiees.html.twig', [
            'histoiresPubliees' => $bhr->findPaginatedPublieesNonSignalees($request->query->getInt('page',1)),
        ]); 
    }


    /* Histoires en attente */
    #[Route('/admin/histoires/attente', name: 'app_admin_histoires_attente')]
    public function findHistoiresWaiting(BelleHistoireRepository $bhr, Request $request): Response
    {
        return $this->render('admin/belles_histoires/en_attente.html.twig', [
            'histoiresWaiting' => $bhr->findPaginatedWaiting($request->query->getInt('page',1)),
        ]); 
    }


    /* Histoires désapprouvées */
    #[Route('/admin/histoires/desapprouvees', name: 'app_admin_histoires_desapprouvees')]
    public function findHistoiresDesapprouvees(BelleHistoireRepository $bhr, Request $request): Response
    {
        return $this->render('admin/belles_histoires/desapprouvees.html.twig', [
            'histoiresDesapprouvees' => $bhr->findPaginatedDisapprouved($request->query->getInt('page',1)),
        ]); 
    }

    /*  Histoires signalées */
    #[Route('/admin/histoires/signalees', name: 'app_admin_histoires_signalees')]
    public function findHistoiresSignalees(ReportHistoireRepository $rhr, Request $request): Response
    {
        return $this->render('admin/belles_histoires/histoires_signalees.html.twig', [
            'histoiresSignalees' => $rhr->findPaginatedPublieesSignalees($request->query->getInt('page',1)),
        ]); 
    }

    /* Liste des commentaires */
    #[Route('/admin/histoires/commentaires', name: 'app_admin_histoires_commentaires')]
    public function findCommentairesNonSignales(CommentBelleHistoireRepository $cbhr, ManagerRegistry $doctrine, Request $request): Response
    {

        return $this->render('admin/belles_histoires/commentaires.html.twig', [
            'commentaires' => $cbhr->findPaginatedNonSignales($request->query->getInt('page',1)),
        ]);  

    }

    #[Route('/admin/histoires/commentaires/signales', name: 'app_admin_histoires_commentaires_signales')]
    public function findCommentairesSignales(ReportCommentRepository $rcr, ManagerRegistry $doctrine, Request $request): Response
    {

        return $this->render('admin/belles_histoires/commentaires_signales.html.twig', [
            'commentaires' => $rcr->findPaginatedSignales($request->query->getInt('page',1)),
        ]);  

    }


    /* Genres (+ possibilité d'ajout) */
    #[Route('/admin/histoires/genres', name: 'app_admin_histoires_genres')]
    public function genres(GenreHistoireRepository $ghr, ManagerRegistry $doctrine, Request $request): Response
    {

        $genres = $ghr->findAll();

        // Créer un genre -> directement possible depuis la vue TWIG
        $genre = new GenreHistoire(); 
        $form = $this->createForm(GenreHistoireType::class, $genre);
        /* On intercepte la requête */
        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid()) {
            $genre = $form->getData();  
            $entityManager = $doctrine->getManager();
            $entityManager->persist($genre);
            $entityManager->flush();                                  

            return $this->redirectToRoute(
                'app_admin_histoires_genres',
            );
        }

        return $this->render('admin/belles_histoires/genres.html.twig', [
            'genres' => $genres,
            'formAddGenre' => $form->createView(),
        ]);  

    }

    #[Route('/admin/histoire/{slug}', name: 'app_admin_histoire_show')]
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
                'app_admin_histoire_show',
                ['slug' => $histoire->getSlug()]
            );
        }

        return $this->render('admin/belles_histoires/showHistoire.html.twig', [
            'histoire' => $histoire,
            'formEditHistoire' => $form->createView(),
        ]); 
    }

    #[Route('/admin/commentaire/{id}', name: 'app_admin_commentaire_show')]
    public function showCommentaire(CommentBelleHistoire $commentaire, CommentBelleHistoireRepository $cbhr, Request $request, ManagerRegistry $doctrine): Response
    {

        $form = $this->createForm(CommentHistoireType::class, $commentaire);  
        $form->handleRequest($request);
        $auteur = $commentaire->getAuteur();
        $date = $commentaire->getDateCreation();
        $histoire = $commentaire->getBelleHistoire();

        if($form->isSubmitted() && $form->isValid()) {
            $commentaire = $form->getData();            
                
            $texte = $form->get('texte')->getData();

            $commentaire->setTexte($texte);
            $commentaire->setAuteur($auteur);
            $commentaire->setDateCreation($date);
            $commentaire->setBelleHistoire($histoire); 
            $entityManager = $doctrine->getManager();
            $entityManager->persist($histoire);
            $entityManager->flush();

            $this->addFlash('success', "Le commentaire a été modifié avec succès");

            return $this->redirectToRoute(
                'app_admin_commentaire_show',
                ['id' => $commentaire->getId()]
            );
        }

        return $this->render('admin/belles_histoires/showCommentaire.html.twig', [
            'commentaire' => $commentaire,
            'formEditCommentaire' => $form->createView(),
        ]); 
    }

    #[Route('/admin/commentaire/remove/{id}', name: 'app_admin_comment_remove')]
    public function removeCommentaire(CommentBelleHistoireRepository $cbhr, CommentBelleHistoire $comment)
    {
        $comment = $cbhr->find($comment->getId());

        $cbhr->remove($comment, $flush = true);
  
        $this->addFlash('notice', "Le commentaire a été supprimé");

        return $this->redirectToRoute(
            'app_admin_histoires_commentaires_signales'
        );            
    }

    #[Route('/admin/histoire/disapprouved/{slug}', name: 'app_admin_histoire_disapprouved')]
    public function disapprouvedHistoire(BelleHistoire $histoire,BelleHistoireRepository $bhr, Request $request, ManagerRegistry $doctrine): Response
    {

        $entityManager = $doctrine->getManager();
        $histoire = $bhr->find($histoire->getId());
        $histoire->setEtat('STATE_DISAPPROUVED');
       $entityManager->persist($histoire);        
        $entityManager->flush();

        $this->addFlash('success', "L'histoire a été désapprouvée");

        return $this->redirectToRoute(
            'app_admin_histoire_show',
            ['slug' => $histoire->getSlug()]
        );
    
    }

    #[Route('/admin/histoire/approuved/{slug}', name: 'app_admin_histoire_approuved')]
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
            'app_admin_histoire_show',
            ['slug' => $histoire->getSlug()]
        );
    
    }

    #[Route('/admin/histoire/remove/{id}', name: 'app_admin_histoire_remove')]
    public function removeHistoire(BelleHistoireRepository $bhr, BelleHistoire $histoire, UploaderService $uploaderService)
    {
        $histoire = $bhr->find($histoire->getId());  

        // Comme la photo est nullable dans l'entité, on doit ajouter cette condition sinon ça fait unen erreur si l'image est vide
        if($histoire->getPhoto()){
            $photo = $histoire->getPhoto();
            $folder = 'imgHistoire';
            $uploaderService->delete($photo,$folder);             
        }     
    
        $bhr->remove($histoire, $flush = true);

        $this->addFlash('notice', "L'histoire a été supprimée");

        return $this->redirectToRoute('app_admin_histoires_signalees');            

    }

    #[Route('/admin/histoire/reports/remove/{id}', name: 'app_admin_histoire_remove_reports')]
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
            'app_admin_histoire_show',
            ['slug' => $histoire->getSlug()]
        );          

    }

    #[Route('/admin/commentaire/reports/remove/{id}', name: 'app_admin_commentaire_remove_reports')]
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
            'app_admin_commentaire_show',
            ['id' => $comment->getId()]
        );          

    }


}