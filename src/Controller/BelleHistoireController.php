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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class BelleHistoireController extends AbstractController
{
    #[Route('/bellesHistoires', name: 'app_belles_histoires')]
    public function index(BelleHistoireRepository $bhr): Response
    {

        $listeHistoires = $bhr->findBy([],['dateCreation' => 'DESC']);

        return $this->render('belle_histoire/bellesHistoires.html.twig', [
            'listeHistoires' => $listeHistoires,
        ]);

    }

    #[Route('/bellesHistoires/histoire/{id}', name: 'show_histoire')]
    public function showHistoire(BelleHistoireRepository $bhr, BelleHistoire $histoire, ManagerRegistry $doctrine, Request $request): Response
    {
        $histoire = $bhr->find($histoire->getId());

        $commentaire = new CommentBelleHistoire();
        $form = $this->createForm(CommentHistoireType::class, $commentaire);
        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire = $form->getData();  
            $dateNow = new \DateTime();
            $commentaire->setDateCreation($dateNow);
            $histoire->addCommentaire($commentaire);  
            $entityManager = $doctrine->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();                                  

            return $this->redirectToRoute(
                'show_histoire',
                ['id' => $histoire->getId()]
            );
        }

        return $this->render('belle_histoire/belleHistoire.html.twig', [
            'histoire' => $histoire,
            'formAddComment' => $form->createView(),
        ]);
        
    }

    #[Route('/bellesHistoires/add', name: 'add_histoire')]
    #[Route('/bellesHistoires/edit/{id}', name: 'edit_histoire')]
    public function addHistoire(BelleHistoireRepository $bhr, BelleHistoire $histoire = null, UploaderService $uploaderService, ManagerRegistry $doctrine, Request $request): Response
    {
        $edit = false;
        if($histoire){
            $edit = true;
            $date = $histoire->getDateCreation();
        }else{
            $histoire = new BelleHistoire();
            $date = new \DateTime();            
        }

        $form = $this->createForm(HistoireType::class, $histoire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $histoire = $form->getData();            
               
            $imgHistoire = $form->get('imgHistoire')->getData();
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
            $histoire->setDateCreation($date); 
            // Dans tous les cas, on persist le memorial
            $entityManager = $doctrine->getManager();
            $entityManager->persist($histoire);
            $entityManager->flush();


            return $this->redirectToRoute('app_belles_histoires');
        }

        return $this->render('belle_histoire/add.html.twig', [
            'formAddHistoire' => $form->createView(),
        ]);
        
    }

    #[Route('/bellesHistoires/histoire/remove/{id}', name: 'remove_histoire')]
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

        return $this->redirectToRoute('app_belles_histoires');
    }

    #[Route('/comment/remove/{idHistoire}/{id}', name: 'remove_comment')]
    #[ParamConverter("histoire", options: ["mapping" => ["idHistoire" => "id"]])]
    #[ParamConverter("commentaire", options: ["mapping" => ["id" => "id"]])]
    public function removeComment(CommentBelleHistoireRepository $cbhr, CommentBelleHistoire $comment, BelleHistoire $histoire)
    {
        $comment = $cbhr->find($comment->getId());
        $histoire = $histoire->getId();
        $cbhr->remove($comment, $flush = true);

        return $this->redirectToRoute(
            'show_histoire',
            ['id' => $histoire]
        );
    }

}
