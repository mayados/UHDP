<?php

namespace App\Controller;

use App\Form\HistoireType;
use App\Entity\BelleHistoire;
use App\Service\UploaderService;
use App\Form\CommentHistoireType;
use App\Entity\CommentBelleHistoire;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BelleHistoireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommentBelleHistoireRepository;
use App\Service\SluggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class BelleHistoireController extends AbstractController
{
    #[Route('/bellesHistoires', name: 'app_belles_histoires')]
    public function index(BelleHistoireRepository $bhr, Request $request): Response
    {

        $listeHistoires = $bhr->findPaginatedHistoires($request->query->getInt('page',1));

        return $this->render('belle_histoire/bellesHistoires.html.twig', [
            'listeHistoires' => $listeHistoires,
        ]);

    }

    #[Route('/bellesHistoires/histoire/{slug}', name: 'show_histoire')]
    public function showHistoire(BelleHistoireRepository $bhr, BelleHistoire $histoire, ManagerRegistry $doctrine, Request $request): Response
    {

        $histoire = $bhr->find($histoire->getId());

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

                return $this->redirectToRoute(
                    'show_histoire',
                    ['slug' => $histoire->getSlug()]
                );
            }

            return $this->render('belle_histoire/belleHistoire.html.twig', [
                'histoire' => $histoire,
                'formAddComment' => $form->createView(),
            ]);

        }

        return $this->render('belle_histoire/belleHistoire.html.twig', [
            'histoire' => $histoire,
        ]);

        
    }

    #[Route('/bellesHistoires/add', name: 'add_histoire')]
    #[Route('/bellesHistoires/edit/{slug}', name: 'edit_histoire')]
    public function addHistoire(BelleHistoireRepository $bhr, BelleHistoire $histoire = null, UploaderService $uploaderService, ManagerRegistry $doctrine, Request $request, SluggerService $sluggerService): Response
    {

        // Vérifier si c'est un édit ou une création

        if($this->getUser()){
            $edit = false;
            // EDIT : seul l'auteur de l'histoire peut la modifier
            if($histoire && ($this->getUser() == $histoire->getAuteur())){
                $edit = true;
                $date = $histoire->getDateCreation();
                $auteur = $histoire->getAuteur();
            }elseif(!$histoire && $this->getUser()->isVerified()){
                $histoire = new BelleHistoire();
                $date = new \DateTime();          
                $auteur = $this->getUser();  
            }else{
                return $this->redirectToRoute('app_login');
            }


            $form = $this->createForm(HistoireType::class, $histoire);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
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

                return $this->redirectToRoute('app_belles_histoires');
            }

            return $this->render('belle_histoire/add.html.twig', [
                'formAddHistoire' => $form->createView(),
                'edit' => $edit,
            ]);            
        }

        // S'il n'y a pas de User, ou qu'il ne s'est pas vérifié, il est rédirigé vers la page de connexion
        return $this->redirectToRoute('app_login');
        
    }

    #[Route('/bellesHistoires/histoire/remove/{id}', name: 'remove_histoire')]
    public function removeHistoire(BelleHistoireRepository $bhr, BelleHistoire $histoire, UploaderService $uploaderService)
    {
        $histoire = $bhr->find($histoire->getId());  

        if($this->getUser() && ($this->getUser() == $histoire->getAuteur() || $this->isGranted('ROLE_ADMIN'))){
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
        
        return $this->redirectToRoute('app_login');

    }

    #[Route('/comment/remove/{slug}/{id}', name: 'remove_comment')]
    #[ParamConverter("histoire", options: ["mapping" => ["slug" => "slug"]])]
    #[ParamConverter("commentaire", options: ["mapping" => ["id" => "id"]])]
    public function removeComment(CommentBelleHistoireRepository $cbhr, CommentBelleHistoire $comment, BelleHistoire $histoire, BelleHistoireRepository $bhr)
    {
        $comment = $cbhr->find($comment->getId());

        // Seuls l'admin OU l'auteur du commentaire peuvent l'effacer
        if($this->getUser() && ( $this->getUser() == $comment->getAuteur() || $this->isGranted('ROLE_ADMIN'))){
            $cbhr->remove($comment, $flush = true);
            $histoire = $bhr->find($histoire->getId());

            $this->addFlash('notice', "Le commentaire a été supprimé");

            return $this->redirectToRoute(
                'show_histoire',
                ['slug' => $histoire->getSlug()]
            );            
        }

        return $this->redirectToRoute('app_login');

    }

}
