<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\MemorialType;
use App\Entity\AnimalMemorial;
use App\Form\GaleriePhotoType;
use App\Entity\CategorieAnimal;
use App\Service\UploaderService;
use App\Repository\PhotoRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\AnimalMemorialRepository;
use App\Repository\CategorieAnimalRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\HttpClient\GEOHttpClient as GEOHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MemorialController extends AbstractController
{
    #[Route('/memoriaux', name: 'app_memoriaux')]
    public function index(AnimalMemorialRepository $amr, CategorieAnimalRepository $car): Response
    {
        $listeMemoriaux = $amr->findBy([],['dateCreation' => 'DESC']);

        $categories = $car->findAll();

        return $this->render('memorial/listeMemoriaux.html.twig', [
            'listeMemoriaux' => $listeMemoriaux,
            'categories' => $categories,
        ]);
    }

    #[Route('/categorie/{id}', name: 'app_categorie')]
    public function memoriauxParCategorie(AnimalMemorialRepository $amr, CategorieAnimalRepository $car, CategorieAnimal $categorie): Response
    {
        $memoriaux = $amr->findBy(['categorieAnimal' => $categorie->getId()],['dateCreation' => 'DESC']);
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
        
        // On vérifie que le user courant est le créateur du mémorial, sinon on ne peut pas accéder au formulaire d'ajout de photo
        if($this->getUser() && $this->getUser()== $memorial->getAuteur()){
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

        return $this->render('memorial/memorial.html.twig',[
                'memorial' => $memorial,
        ]);

    }

    // Pour autocompléter le nom du lieu du mémorial (ne fonctionne pas quand la requête est effectuée avec la route /memoriaux/add)
    #[Route('/villes', name: 'add_ville', methods: ['POST'])]
    public function lieu(Request $request, GEOHttpClient $geo){
        $search = $request->request->get('searchValue');
        return new Response($geo->getVilles($search));
        return $this->render('memorial/add.html.twig');
    }

    #[Route('/memoriaux/add', name: 'add_memorial')]
    #[Route('/memoriaux/edit/{id}', name: 'edit_memorial')]
    public function add(ManagerRegistry $doctrine, AnimalMemorial $memorial = null, UploaderService $uploaderService, Request $request, GEOHttpClient $geo): Response
    {

        if($this->getUser()){
            $edit = false;
            // EDIT : seul le créateur du mémorial peut le modifier
            if($memorial && ($this->getUser() == $memorial->getAuteur())){
                $edit = true;
                $date = $memorial->getDateCreation();
            // CREATION : seul un utilisateur connecté ET vérifié peut créer un mémorial 
            }elseif(!$memorial && $this->getUser()->isVerified()){
                $memorial = new AnimalMemorial();
                $date = new \DateTime();            
            }else{
                return $this->redirectToRoute('app_login');
            }

            $form = $this->createForm(MemorialType::class, $memorial);
            $form->handleRequest($request);
            // dd($this->getUser());
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
                $memorial->setAuteur($this->getUser());
                $memorial->setDateCreation($date); 
                // Dans tous les cas, on persist le memorial
                $entityManager = $doctrine->getManager();
                $entityManager->persist($memorial);
                $entityManager->flush();


                return $this->redirectToRoute('app_memoriaux');
            }

            return $this->render('memorial/add.html.twig', [
                'formAddMemorial' => $form->createView(),
                'edit' => $edit,
            ]);            
        }

        return $this->redirectToRoute('app_login');        

    }

    #[Route('/memorial/remove/{id}', name: 'remove_memorial')]
    public function removeMemorial(AnimalMemorialRepository $amr, AnimalMemorial $memorial, UploaderService $uploaderService)
    {

        // Nous cherchons le mémorial ayant pour id l'id envoyé, puis nous l'enlevons de la base de données avec remove() (fonction intégrer de base au repository)
        $memorial = $amr->find($memorial->getId());        

        // Seuls l'admin ou l'utilisateur qui a créé la mémorial peuvent le supprimer
        if($this->getUser() && ($this->getUser() == $memorial->getAuteur() || $this->isGranted('ROLE_ADMIN'))){

            // Comme la photo est nullable dans l'entité, on doit ajouter cette condition sinon ça fait unen erreur si l'image est vide
            if($memorial->getPhoto()){
                $photoMemo = $memorial->getPhoto();
                $folder = 'imgMemorial';
                $uploaderService->delete($photoMemo, $folder);            
            }

            // Si le mémorial a des photos dans sa galerie...
            if($memorial->getPhotos()){
                // On pense à récupérer les images de la galerie pour les effacer aussi dans le dossier imgGalerie et pas seulement en base de données
                $photos = $memorial->getPhotos();
                foreach($photos as $photo){
                    // On récupère la string et non l'objet en lui même, car il faut connaître le nom du fichier à supprimer            
                    $photo = $photo->getPhoto();
                    $folder = 'imgGalerie';
                    $uploaderService->delete($photo,$folder);            
                }            
            }

            /*  Les photos de la galerie seront aussi supprimées de l'entity Photo (qui représente la galerie photo comme plusieurs photos 
                peuvent être ajoutées),grâce au Orphean Removal*/
            $amr->remove($memorial, $flush = true);

            return $this->redirectToRoute("app_memoriaux");            
        }

        return $this->redirectToRoute('app_login'); 

    }

    #[Route('/memorial/{idMemorial}/galerie/delete/{id}', name: 'remove_photo')]
    #[ParamConverter("memorial", options: ["mapping" => ["idMemorial" => "id"]])]
    #[ParamConverter("image", options: ["mapping" => ["id" => "id"]])]
    public function removePhotoGalerie(PhotoRepository $pr, Photo $photo, AnimalMemorial $memorial, UploaderService $uploaderService)
    {

        if ($this->getUser() && ($this->getUser() == $memorial->getAuteur() || $this->isGranted('ROLE_ADMIN'))) {
                $photo = $pr->find($photo->getId());
                $folder = 'imgGalerie';
                $uploaderService->delete($photo->getPhoto(),$folder);
                $pr->remove($photo, $flush = true);

                return $this->redirectToRoute(
                    'show_memorial',
                    ['id' => $memorial->getId()],
                );
            }    

            return $this->redirectToRoute('app_login'); 
        }

}
