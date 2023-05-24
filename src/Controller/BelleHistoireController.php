<?php

namespace App\Controller;

use App\Form\HistoireType;
use App\Entity\BelleHistoire;
use App\Entity\GenreHistoire;
use App\Service\SluggerService;
use App\Service\UploaderService;
use App\Form\CommentHistoireType;
use App\Entity\CommentBelleHistoire;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BelleHistoireRepository;
use App\Repository\GenreHistoireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommentBelleHistoireRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class BelleHistoireController extends AbstractController
{
    #[Route('/bellesHistoires', name: 'app_belles_histoires')]
    public function index(BelleHistoireRepository $bhr, GenreHistoireRepository $ghr, Request $request): Response
    {

        $genres = $ghr->findAll();
        $listeHistoires = $bhr->findPaginatedHistoires($request->query->getInt('page',1));

        return $this->render('belle_histoire/bellesHistoires.html.twig', [
            'listeHistoires' => $listeHistoires,
            'genres' => $genres
        ]);

    }


    #[Route('/bellesHistoires/add', name: 'add_histoire')]
    #[Route('/bellesHistoires/edit/{slug}', name: 'edit_histoire')]
    #[Security("is_granted('ROLE_USER') and user.isVerified() === true", message:"Seuls les utilisateurs connectés et vérifiés peuvent accéder à cette page.")]
    public function addHistoire(BelleHistoireRepository $bhr, BelleHistoire $histoire = null, UploaderService $uploaderService, ManagerRegistry $doctrine, Request $request, SluggerService $sluggerService): Response
    {

        // Vérifier si c'est un édit ou une création
        $edit = false;
        // EDIT : seul l'auteur de l'histoire peut la modifier
        if($histoire && ($this->getUser() == $histoire->getAuteur())){
            if($histoire->getEtat() === 'STATE_DRAFT' || $histoire->getEtat() === 'STATE_APPROUVED'){
                $edit = true;
                $date = $histoire->getDateCreation();
                $auteur = $histoire->getAuteur();                    
            }else{
                $this->addFlash('warning', "Seules les histoires publiées ou à l'état de brouillon peuvent être éditées");
                return $this->redirectToRoute('my_histoires');
            }
        }elseif(!$histoire){
            $histoire = new BelleHistoire();
            $date = new \DateTime();          
            $auteur = $this->getUser();  
        }else{
            return $this->redirectToRoute('app_belles_histoires');
        }
 
        $form = $this->createForm(HistoireType::class, $histoire);  
        $form->handleRequest($request);

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

            ($edit)?$this->addFlash('success', "L'histoire a été modifiée avec succès"):$this->addFlash('success', "L'histoire a été créée avec succès");

            return $this->redirectToRoute('my_histoires');
        }

        return $this->render('belle_histoire/add.html.twig', [
            'formAddHistoire' => $form->createView(),
            'edit' => $edit,
        ]);            
    }


    #[Route('/bellesHistoires/{id}', name: 'app_belles_histoires_genre')]
    public function findHistoiresByGenre(GenreHistoire $genre,BelleHistoireRepository $bhr, GenreHistoireRepository $ghr, Request $request): Response
    {

        $genreId = $genre->getId();
        $genres = $ghr->findAll();
        $listeHistoires = $bhr->findPaginatedHistoiresByGenre($request->query->getInt('page',1),$genreId);

        return $this->render('belle_histoire/bellesHistoiresGenre.html.twig', [
            'listeHistoires' => $listeHistoires,
            'genres' => $genres,
            'genre' => $genre,
        ]);

    }

    #[Route('/bellesHistoires/publier/{slug}', name: 'publish_histoire')]
    #[Security("is_granted('ROLE_USER') and user === histoire.getAuteur()", message:"Accès non autorisé.")]
    public function publishHistoire(BelleHistoireRepository $bhr, BelleHistoire $histoire ,Request $request,ManagerRegistry $doctrine): Response
    {

            $histoire->setEtat('STATE_WAITING');
            $entityManager = $doctrine->getManager();
            $entityManager->persist($histoire);
            $entityManager->flush();      

            $this->addFlash('notice', "L'histoire a été soumise à la modération. Elle sera traitée dans les plus brefs délais");

            return $this->redirectToRoute('my_histoires');            

    }


    #[Route('/bellesHistoires/histoire/{slug}', name: 'show_histoire')]
    #[Route('/bellesHistoires/histoire/{idGenre}/{slug}', name: 'show_histoire_genre')]
    #[ParamConverter("genre", options: ["mapping" => ["idGenre" => "id"]])]    
    #[ParamConverter("histoire", options: ["mapping" => ["slug" => "slug"]])]
    public function showHistoire(BelleHistoireRepository $bhr, BelleHistoire $histoire = null, GenreHistoire $genre = null, CommentBelleHistoireRepository $cbhr, ManagerRegistry $doctrine, Request $request): Response
    {
        if($histoire) {

            if($genre){
                $consultedInGenre = true;
            }elseif(!$genre){
                $consultedInGenre = false;            
            }
    
            $histoire = $bhr->find($histoire->getId());
            $commentaires = $cbhr->findCommentaires($histoire,$request->query->getInt('page',1));
    
            $idHistoire = $histoire->getId();
    
            // S'il y a un utilisateur et qu'il est vérifié, il a le droit à accéder au formulaire de commentaire, sinon non
            if($this->getUser() && $this->getUser()->isVerified()){
                $commentaire = new CommentBelleHistoire();
                $form = $this->createForm(CommentHistoireType::class, $commentaire);
                $form->handleRequest($request); 
                if ($form->isSubmitted() && $form->isValid()) {
                    $commentaire = $form->getData();  
                    $dateNow = new \DateTime();
                    $commentaire->setAuteur($this->getUser());
                    $commentaire->setBelleHistoire($histoire);
                    $commentaire->setDateCreation($dateNow);
                    $histoire->addCommentaire($commentaire);  
                    $entityManager = $doctrine->getManager();
                    $entityManager->persist($commentaire);
                    $entityManager->flush();                                  
    
                    if($request->isXmlHttpRequest()){
                        // Si c'est le cas on renvoie du JSON
                        return new JsonResponse([
                            'content' => $this->renderView('_partials/_commentaires.html.twig', ['histoire' => $histoire, 'consultedInGenre' => $consultedInGenre,'commentaires' => $cbhr->findCommentaires($histoire,$request->query->getInt('page',1))]),
                        ]);
                    }
    
                    if($genre){
                        return $this->redirectToRoute(
                            'show_histoire_genre',
                            ['slug' => $histoire->getSlug(),
                            'idGenre' => $genre->getId()]
                        );
                    }
    
                    return $this->redirectToRoute(
                        'show_histoire',
                        ['slug' => $histoire->getSlug()]
                    );
                }
    
                return $this->render('belle_histoire/belleHistoire.html.twig', [
                    'histoire' => $histoire,
                    'formAddComment' => $form->createView(),
                    'autresHistoires' => $bhr->findAutresHistoires($idHistoire),
                    'consultedInGenre' => $consultedInGenre,
                    'commentaires' => $commentaires,
                ]);
            }
    
            return $this->render('belle_histoire/belleHistoire.html.twig', [
                'histoire' => $histoire,
                'autresHistoires' => $bhr->findAutresHistoires($idHistoire),
                'consultedInGenre' => $consultedInGenre,
                'commentaires' => $commentaires,
            ]);
        } else {
            return $this->redirectToRoute("app_belles_histoires");
        }
    }


    #[Route('/bellesHistoires/histoire/remove/{id}', name: 'remove_histoire')]
    #[Security("is_granted('ROLE_USER') and user === histoire.getAuteur()", message:"Accès non autorisé.")]
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

        return $this->redirectToRoute('app_belles_histoires');            

    }

    #[Route('/comment/remove/{slug}/{id}', name: 'remove_comment')]
    #[Route('/comment/remove/{idGenre}/{slug}/{id}', name: 'remove_comment_genre')]
    #[ParamConverter("histoire", options: ["mapping" => ["slug" => "slug"]])]
    #[ParamConverter("commentaire", options: ["mapping" => ["id" => "id"]])]
    #[ParamConverter("genre", options: ["mapping" => ["idGenre" => "id"]])]
    #[Security("is_granted('ROLE_USER') and user === comment.getAuteur()", message:"Accès non autorisé.")]
    public function removeComment(CommentBelleHistoireRepository $cbhr, CommentBelleHistoire $comment, BelleHistoire $histoire, GenreHistoire $genre = null, BelleHistoireRepository $bhr)
    {
        $comment = $cbhr->find($comment->getId());

        $cbhr->remove($comment, $flush = true);
        $histoire = $bhr->find($histoire->getId());

        $this->addFlash('notice', "Le commentaire a été supprimé");


        if(!$genre){
            return $this->redirectToRoute(
                'show_histoire',
                ['slug' => $histoire->getSlug()]
            );              
        }
          
        return $this->redirectToRoute(
            'show_histoire_genre',
            ['slug' => $histoire->getSlug(),
            'idGenre' => $genre->getId()]
        );      

    }

}
