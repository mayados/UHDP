<?php

namespace App\Controller;

use App\Form\MemorialType;
use App\Entity\AnimalMemorial;
use App\Entity\CategorieAnimal;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\AnimalMemorialRepository;
use App\Repository\CategorieAnimalRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class MemorialController extends AbstractController
{
    #[Route('/memoriaux', name: 'app_memoriaux')]
    public function index(AnimalMemorialRepository $amr, CategorieAnimalRepository $car): Response
    {
        $listeMemoriaux = $amr->findAll();

        $categories = $car->findAll();

        return $this->render('memorial/listeMemoriaux.html.twig', [
            'listeMemoriaux' => $listeMemoriaux,
            'categories' => $categories,
        ]);
    }

    #[Route('/categorie/{id}', name: 'app_categorie')]
    public function memoriauxParCategorie(CategorieAnimalRepository $car, CategorieAnimal $categorie): Response
    {
        $categorie = $car->find($categorie->getId());

        return $this->render('memorial/listeParCategorie.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    #[Route('/memorial/{id}', name: 'show_memorial')]
    public function showMemorial(AnimalMemorialRepository $amr, AnimalMemorial $memorial): Response
    {
        $memorial = $amr->find($memorial->getId());

        return $this->render('memorial/memorial.html.twig', [
            'memorial' => $memorial,
        ]);
    }

    #[Route('/memoriaux/add', name: 'add_memorial')]
    #[Route('/memoriaux/edit/{id}', name: 'edit_memorial')]
    public function add(ManagerRegistry $doctrine, AnimalMemorial $memorial = null, SluggerInterface $slugger, Request $request): Response
    {

        $edit = false;
        if($memorial){
            $edit = true;
        }

        if(!$memorial){
            $memorial = new AnimalMemorial();
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
                    // On cherche le path du dossier où sont stockées les images du mémorial
                    $path = $this->getParameter('imgMemorial_directory');
                    // On indique le chemin complet vers le fichier de la photo à remplacer
                    $fichierPreviousPhoto = $path ."/". $previousPhoto;
                    //  On supprime le fichier de l'ancienne photo car on ne s'en sert plus, le garder ferait perdre de l'espace
                    if(file_exists($fichierPreviousPhoto)){
                        unlink($fichierPreviousPhoto);
                    }                    
                }

                $originalFileName = pathinfo($imgMemorial->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFileName);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imgMemorial->guessExtension();

                try{
                    $imgMemorial->move(
                        $this->getParameter('imgMemorial_directory'),
                        $newFilename
                    );

                }   catch (FileException $e){

                }

                $memorial->setPhoto($newFilename);
            }


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
