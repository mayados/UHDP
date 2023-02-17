<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\MemorialType;
use App\Entity\AnimalMemorial;
use App\Form\GaleriePhotoType;
use App\Entity\CategorieAnimal;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\AnimalMemorialRepository;
use App\Repository\CategorieAnimalRepository;
use App\Service\UploaderService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class MemorialController extends AbstractController
{
    #[Route('/memoriaux', name: 'app_memoriaux')]
    public function index(AnimalMemorialRepository $amr, CategorieAnimalRepository $car): Response
    {
        $listeMemoriaux = $amr->findBy([],['dateCreation' => 'ASC']);

        $categories = $car->findAll();

        return $this->render('memorial/listeMemoriaux.html.twig', [
            'listeMemoriaux' => $listeMemoriaux,
            'categories' => $categories,
        ]);
    }

    #[Route('/categorie/{id}', name: 'app_categorie')]
    public function memoriauxParCategorie(AnimalMemorialRepository $amr, CategorieAnimalRepository $car, CategorieAnimal $categorie): Response
    {
        $memoriaux = $amr->findBy(['categorieAnimal' => $categorie->getId()],['dateCreation' => 'ASC']);
        $categorieMemorial = $car->find($categorie->getId());

        return $this->render('memorial/listeParCategorie.html.twig', [
            'memoriaux' => $memoriaux,
            'categorie' => $categorieMemorial,
        ]);
    }

    #[Route('/memorial/{id}', name: 'show_memorial')]
    public function showMemorial(ManagerRegistry $doctrine, AnimalMemorialRepository $amr, UploaderService $uploaderService, AnimalMemorial $memorial, Request $request, SluggerInterface $slugger): Response
    {
        $memorial = $amr->find($memorial->getId());

        // On souhaite insérer le formulaire d'ajout d'image à la galerie photo directement dans la page du mémorial
        // Dans un premier temps on persist dans la bdd de Photos le nom des fichiers
        // Puis on add chaque image grâce à la méthode de l'entity AnimalMemorial (qui contient un collectionType)
        $galerie = new Photo();
        $form = $this->createForm(GaleriePhotoType::class, $galerie);
        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) {
            $galerie = $form->getData();  
            $galerie->setMemorial($memorial);
            $images = $form->get('images')->getData();

            foreach($images as $image){
                $folder = "imgGalerie";
                $fichier = $uploaderService->add($image,$folder);
                $photo= new Photo();
                $photo->setPhoto($fichier);
                $memorial->addPhoto($photo);  
                $entityManager = $doctrine->getManager();
                $entityManager->persist($photo);
                $entityManager->flush();                                  
            }


            return $this->redirectToRoute(
                'show_memorial',
                ['id' => $memorial->getId()]
            );
        }


        return $this->render('memorial/memorial.html.twig', [
            'memorial' => $memorial,
            'formAddPhotoGalerie' => $form->createView(),
        ]);
    }

    #[Route('/memoriaux/add', name: 'add_memorial')]
    #[Route('/memoriaux/edit/{id}', name: 'edit_memorial')]
    public function add(ManagerRegistry $doctrine, AnimalMemorial $memorial = null, UploaderService $uploaderService, Request $request): Response
    {

        $edit = false;
        if($memorial){
            $edit = true;
            $date = $memorial->getDateCreation();
        }else{
            $memorial = new AnimalMemorial();
            $date = new \DateTime();            
        }

        $form = $this->createForm(MemorialType::class, $memorial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $memorial = $form->getData();            
            $imgMemorial = $form->get('imgMemorial')->getData();
            if($imgMemorial){
                // Si on est dans le cas d'un edit et qu'une nouvelle image est uploadée (car lors d'un ajout on ne va pas supprimer le fichier qu'ion crée..)
                if($memorial->getPhoto() != null){
                    // On cherche la photo stockée pour le mémorial correspondant
                    $previousPhoto = $memorial->getPhoto();

                    $folder = 'imgMemorial';
                    $uploaderService->delete($previousPhoto,$folder);
                }
                // Dans le cas où il y a une image soumise mais que le mémorial n'a pas encore d'image (=> cas d'ajout de mémorial ou edit sans image)
                $folder = 'imgMemorial';
                $image = $uploaderService->add($imgMemorial,$folder);
                $memorial->setPhoto($image);                              
            }
            $memorial->setDateCreation($date); 
            // Dans tous les cas, on persist le memorial
            $entityManager = $doctrine->getManager();
            $entityManager->persist($memorial);
            $entityManager->flush();


            return $this->redirectToRoute('app_memoriaux');
        }

        return $this->render('memorial/add.html.twig', [
            'formAddMemorial' => $form->createView(),
        ]);

    }

}
