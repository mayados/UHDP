<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Data\SearchData;
use App\Form\SearchType;
use App\Form\MemorialType;
use App\Entity\Condoleance;
use App\Form\CondoleanceType;
use App\Entity\AnimalMemorial;
use App\Form\GaleriePhotoType;
use App\Entity\CategorieAnimal;
use App\Service\UploaderService;
use App\Form\EditCondoleanceType;
use App\Repository\PhotoRepository;
use App\Repository\CondoleanceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\AnimalMemorialRepository;
use App\Repository\CategorieAnimalRepository;
use Symfony\Component\HttpFoundation\Request;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\HttpClient\GEOHttpClient as GEOHttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormError;

class MemorialController extends AbstractController
{
    #[Route('/memoriaux', name: 'app_memoriaux')]
    public function index(AnimalMemorialRepository $amr, CategorieAnimalRepository $car, Request $request): Response
    {
        $categories = $car->findAll();

        $now = new \DateTime();

        // On veut également mettre un système de recherche dans la vue 
        $searchData = new SearchData();
        //  ON range les infos dans l'objet searchData
        $form = $this->createForm(SearchType::class, $searchData);

        $form->handleRequest($request);
            // dd($searchData);        
        if($form->isSubmitted() && $form->isValid()){

            $page = $request->query->getInt('page',1);
            // $searchData->page = $request->query->getInt('page',1);
            $memoriaux = $amr->findBySearch($searchData,$page);
            // On vérifie si on est en AJAX
            if($request->isXmlHttpRequest()){
                // Si c'est le cas on renvoie du JSON
                return new JsonResponse([
                    'content' => $this->renderView('_partials/_memoriaux.html.twig', ['memoriaux' => $memoriaux]),
                    'pagination' => $this->renderView('_partials/_pagination.html.twig', ['memoriaux' => $memoriaux])
                ]);
            }

            return $this->render('memorial/listeMemoriaux.html.twig',[
            'categories' => $categories,   
             'memoriaux' => $memoriaux,   
             'formSearch' => $form->createView(),
            ]);

        }

        return $this->render('memorial/listeMemoriaux.html.twig', [
            'memoriaux' => $amr->findPaginatedMemoriaux($request->query->getInt('page',1)),
            'categories' => $categories,
            'formSearch' => $form->createView(),
            'souvenirs' => $amr->findMemoriauxOfMonth($now),
        ]);
    }

    #[Route('/memoriaux/recherche', name: 'app_memoriaux_recherche')]
    public function findResearch(AnimalMemorialRepository $amr, CategorieAnimalRepository $car, Request $request): Response
    {
        // $categories = $car->findAll();

        // On veut également mettre un système de recherche dans la vue 
        $searchData = new SearchData();
        //  ON range les infos dans l'objet searchData
        $form = $this->createForm(SearchType::class, $searchData);

        $form->handleRequest($request);
            // dd($searchData);        
        if($form->isSubmitted() && $form->isValid()){


            $page = $request->query->getInt('page',1);
            // $searchData->page = $request->query->getInt('page',1);
            $memoriaux = $amr->findBySearch($searchData,$page);
            // On vérifie si on est en AJAX
            if($request->isXmlHttpRequest()){
                // Si c'est le cas on renvoie du JSON
                return new JsonResponse([
                    'content' => $this->renderView('_partials/_memoriaux.html.twig', ['memoriaux' => $memoriaux]),
                    'pagination' => $this->renderView('_partials/_pagination.html.twig', ['memoriaux' => $memoriaux])
                ]);
            }

            $empty = [];
            

            return $this->render('memorial/recherche.html.twig',[
            // 'categories' => $categories,   
             'memoriaux' => $memoriaux,   
             'formSearch' => $form->createView(),
            ]);

        }

        return $this->render('memorial/recherche.html.twig', [
            'memoriaux' => null,
            // 'categories' => $categories,
            'formSearch' => $form->createView(),
        ]);
    }

    #[Route('/categorie/{id}', name: 'app_categorie')]
    public function memoriauxParCategorie(AnimalMemorialRepository $amr, CategorieAnimalRepository $car, CategorieAnimal $categorie, Request $request): Response
    {

        $categorieMemorial = $car->find($categorie->getId()); 

        // On veut également mettre un système de recherche dans la vue 
        $searchData = new SearchData();
        // On veut également mettre un système de recherche dans la vue 
        $form = $this->createForm(SearchType::class,$searchData);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $page = $request->query->getInt('page',1);
        // dd($searchData);            
            $memoriaux = $amr->findSearchByCategorie($searchData,$categorieMemorial,$page);
            // On vérifie si on est en AJAX
            if($request->isXmlHttpRequest()){
                // Si c'est le cas on renvoie du JSON
                return new JsonResponse([
                    'content' => $this->renderView('_partials/_memoriauxCategorie.html.twig', ['memoriaux' => $memoriaux, 'categorie'=>$categorieMemorial]),
                    'pagination' => $this->renderView('_partials/_pagination.html.twig', ['memoriaux' => $memoriaux, 'categorie'=>$categorieMemorial])
                ]);
            }
            return $this->render('memorial/listeParCategorie.html.twig',[
            'categorie' => $categorieMemorial,   
             'memoriaux' => $memoriaux,   
             'formSearch' => $form->createView(),
            ]);

        }

        return $this->render('memorial/listeParCategorie.html.twig', [
            'memoriaux' => $amr->findPaginatedMemoriauxByCategorie($request->query->getInt('page',1),$categorieMemorial),
            'categorie' => $categorieMemorial,
            'formSearch' => $form->createView(),
        ]);
    }

    #[Route('/memorial/{id}', name: 'show_memorial')]
    #[Route('/memorial/{idCategorie}/{id}', name: 'show_memorial_categorie')]
    #[ParamConverter("memorial", options: ["mapping" => ["id" => "id"]])]
    #[ParamConverter("categorie", options: ["mapping" => ["idCategorie" => "id"]])]
    public function showMemorial(ManagerRegistry $doctrine, AnimalMemorialRepository $amr, CondoleanceRepository $cr, UploaderService $uploaderService, AnimalMemorial $memorial, Request $request, CategorieAnimal $categorie = null, SluggerInterface $slugger): Response
    {

        if($categorie){
            $consultedInCategorie = true;
        }elseif(!$categorie){
            $consultedInCategorie = false;            
        }


        $memorial = $amr->find($memorial->getId());
        $galerie = new Photo();
        $form = $this->createForm(GaleriePhotoType::class, $galerie);    
        $condoleance = new Condoleance();
        $condoleanceForm = $this->createForm(CondoleanceType::class,$condoleance);
            // $editCondoleanceForm = $this->createForm(CondoleanceType::class,$condoleance);       
        $condoleances = $cr->findPaginatedCondoleances($memorial,$request->query->getInt('page',1));
        // $editCondoleanceForm = $this->createForm(CondoleanceType::class,$condoleance); 

        if($this->getUser()){
            $condoleanceForm->handleRequest($request); 
            if ($condoleanceForm->isSubmitted() && $condoleanceForm->isValid()) {
                $condoleance = $condoleanceForm->getData();
                $condoleance->setMemorial($memorial);
                $condoleance->setAuteur($this->getUser());
                $entityManager = $doctrine->getManager();
                $entityManager->persist($condoleance);
                $entityManager->flush();   

                if($request->isXmlHttpRequest()){
                    // Si c'est le cas on renvoie du JSON
                    return new JsonResponse([
                        'content' => $this->renderView('_partials/_condoleances.html.twig', ['memorial' => $memorial,'formCondoleance' => $condoleanceForm->createView(),'consultedInCategorie' => $consultedInCategorie, 'condoleances' => $cr->findCondoleances($memorial)]),
                        // 'formCondoleance' => $this->renderView('_partials/_refreshForm.html.twig', ['formCondoleance' => $condoleanceForm->createView()])
                        // 'bloup'=> 'blou',
                    ]);
                }
                // return $this->json([
                //     'message' => 'ca fonctioenne.',
                // ]);

                if(!$categorie){
                    return $this->redirectToRoute(
                        'show_memorial',
                        ['id' => $memorial->getId()]
                    );                    
                }

                return $this->redirectToRoute(
                    'show_memorial_categorie',
                    ['id' => $memorial->getId(),
                    'idCategorie' => $categorie->getId()]
                );     

            }else{

                // Si le formulaire n'est pas valide et qu'il s'agit d'une requête AJAX
                if($request->isXmlHttpRequest()){
                    $errorMessage ="";
                    // la fonction getErrors() permet d'obtenir une instance de l'objet FormErrorIterator, pour obtenir le message il faut donc faire appel, pour chaque erreur qu'il pourrait y avoir, à la fonction getMessage()
                    $errors = $condoleanceForm['texte']->getErrors();
                    foreach ($errors as $error) {
                        $errorMessage = $error->getMessage();
                    };

                    // Si c'est le cas on renvoie du JSON
                    return new JsonResponse([
                        'content' => $this->renderView('_partials/_condoleances.html.twig', ['memorial' => $memorial,'consultedInCategorie' => $consultedInCategorie, 'formCondoleance' => $condoleanceForm->createView(),'condoleances' => $cr->findCondoleances($memorial)]),
                        'error' => $errorMessage,
                    ]);
                }

            }

            // On vérifie que le user courant est le créateur du mémorial, sinon on ne peut pas accéder au formulaire d'ajout de photo
            if($this->getUser()== $memorial->getAuteur()){
                // On souhaite insérer le formulaire d'ajout d'image à la galerie photo directement dans la page du mémorial
                // Dans un premier temps on persist dans la bdd de Photos le nom des fichiers
                // Puis on add chaque image grâce à la méthode de l'entity AnimalMemorial (qui contient un collectionType)

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

                    $this->addFlash('success', 'La galerie a été alimentée avec succès');

                    if(!$categorie){
                        return $this->redirectToRoute(
                            'show_memorial',
                            ['id' => $memorial->getId()]
                        );                        
                    }

                    return $this->redirectToRoute(
                        'show_memorial_categorie',
                        ['id' => $memorial->getId(),
                        'idCategorie' => $categorie->getId()]
                    );     

                }

                return $this->render('memorial/memorial.html.twig', [
                    'memorial' => $memorial,
                    'formAddPhotoGalerie' => $form->createView(),
                    'formCondoleance' => $condoleanceForm->createView(),
                    'consultedInCategorie' => $consultedInCategorie,
                    'condoleances' => $condoleances,
                    // 'editCondoleanceForm' => $editCondoleanceForm->createView(),
                ]);            
            }
        }
        return $this->render('memorial/memorial.html.twig',[
                'memorial' => $memorial,
                'formAddPhotoGalerie' => $form->createView(),
                'formCondoleance' => $condoleanceForm->createView(),
                'consultedInCategorie' => $consultedInCategorie,
                'condoleances' => $condoleances,
                // 'editCondoleanceForm' => $editCondoleanceForm->createView(),
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
    #[Security("is_granted('ROLE_USER') and user.isVerified() === true", message:"Seuls les utilisateurs connectés et vérifiés peuvent accéder à cette page.")]
    public function add(ManagerRegistry $doctrine, AnimalMemorial $memorial = null, UploaderService $uploaderService, Request $request, GEOHttpClient $geo): Response
    {

        $edit = false;
        // EDIT : seul le créateur du mémorial peut le modifier
        if($memorial && ($this->getUser() == $memorial->getAuteur())){
            $edit = true;
            $date = $memorial->getDateCreation();
        // CREATION 
        }elseif(!$memorial){
            $memorial = new AnimalMemorial();
            $date = new \DateTime();  
            // Si le user n'est pas l'auteur du mémorial on redirige vers les memoriaux          
        }else{
            return $this->redirectToRoute('app_memoriaux');
        }

        $form = $this->createForm(MemorialType::class, $memorial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $memorial = $form->getData();            
            $imgMemorial = $form->get('imgMemorial')->getData();
            if($imgMemorial){
                // Si on est dans le cas d'un edit et qu'une nouvelle image est uploadée (car lors d'un ajout on ne va pas supprimer le fichier qu'on crée..)
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

            ($edit)?$this->addFlash('success', 'Le mémorial a été modifié avec succès'):$this->addFlash('success', 'Le mémorial a été créé avec succès');

            return $this->redirectToRoute('app_memoriaux');
        }

        return $this->render('memorial/add.html.twig', [
            'formAddMemorial' => $form->createView(),
            'edit' => $edit,
            'memorial' => $memorial
        ]);            
    }

    #[Route('/memorial/remove/{id}', name: 'remove_memorial')]
    #[Security("is_granted('ROLE_USER') and user === memorial.getAuteur()", message:"Accès non autorisé.")]
    public function removeMemorial(AnimalMemorialRepository $amr, AnimalMemorial $memorial, UploaderService $uploaderService)
    {

        // Nous cherchons le mémorial ayant pour id l'id envoyé, puis nous l'enlevons de la base de données avec remove() (fonction intégrer de base au repository)
        $memorial = $amr->find($memorial->getId());        

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

            $this->addFlash('notice', 'Le mémorial a été supprimé');

            return $this->redirectToRoute("app_memoriaux");            

    }

    #[Route('/condoleance/remove/{idMemorial}/{id}', name: 'remove_condoleance')]
    #[Route('/condoleance/remove/{idCategorie}/{idMemorial}/{id}', name: 'remove_condoleance_categorie')]
    #[ParamConverter("memorial", options: ["mapping" => ["idMemorial" => "id"]])]
    #[ParamConverter("condoleance", options: ["mapping" => ["id" => "id"]])]
    #[ParamConverter("categorie", options: ["mapping" => ["idCategorie" => "id"]])]
    #[Security("is_granted('ROLE_USER') and user === condoleance.getAuteur()", message:"Accès non autorisé.")]
    public function removeCondoleance(CondoleanceRepository $cr, CategorieAnimal $categorie = null, Condoleance $condoleance, AnimalMemorial $memorial, AnimalMemorialRepository $amr)
    {
        $condoleance = $cr->find($condoleance->getId());

        $cr->remove($condoleance, $flush = true);
        $memorial = $amr->find($memorial->getId());

        // $this->addFlash('notice', "La condoléance a été supprimée");

        if(!$categorie){
            // return $this->redirectToRoute(
            //     'show_memorial',
            //     ['id' => $memorial->getId()]
            // );           
            return new JsonResponse([
                'content' => $this->renderView('_partials/_condoleances.html.twig', ['memorial' => $memorial, "condoleances" => $cr->findCondoleances($memorial), 'consultedInCategorie' => false]),

            ]);        
        }

        return new JsonResponse([
            'content' => $this->renderView('_partials/_condoleances.html.twig', ['memorial' => $memorial, "condoleances" => $cr->findCondoleances($memorial), 'consultedInCategorie' => true]),

        ]);   
        // return $this->redirectToRoute(
        //     'show_memorial_categorie',
        //     ['id' => $memorial->getId(),
        //     'idCategorie' => $categorie->getId()]
        // );  
         
    }

    #[Route('/memorial/condoleance/edit/{id}/{idMemorial}', name: 'edit_condoleance')]
    #[ParamConverter("condoleance", options: ["mapping" => ["id" => "id"]])]
    #[ParamConverter("memorial", options: ["mapping" => ["idMemorial" => "id"]])]
    #[Security("is_granted('ROLE_USER') and user === condoleance.getAuteur()", message:"Accès non autorisé.")]
    public function editCondoleance(Condoleance $condoleance, AnimalMemorial $memorial, CondoleanceRepository $cr , CategorieAnimal $categorie = null , ManagerRegistry $doctrine,Request $request)
    {

        if($categorie){
            $consultedInCategorie = true;
        }elseif(!$categorie){
            $consultedInCategorie = false;            
        }

        // On récupère le token généré dans le formulaire
        $submittedToken = $request->request->get('token');
        // $texteTest = $request->request->get('texte');


        if (isset($_POST) && $this->isCsrfTokenValid('modify-item', $submittedToken)) {
            $entityManager = $doctrine->getManager();
            $texte = $request->request->get('texte');
            $condoleance->setMemorial($memorial);
            $date = $condoleance->getDateCreation();
            $auteur = $condoleance->getAuteur();
            $condoleance->setDateCreation($date);
            $condoleance->setAuteur($auteur);
            $condoleance->setTexte($texte);
            $entityManager->persist($condoleance);
            $entityManager->flush();

            if($request->isXmlHttpRequest()){
                // Si c'est le cas on renvoie du JSON
                return new JsonResponse([
                    'content' => $this->renderView('_partials/_condoleances.html.twig', ['memorial' => $memorial, 'condoleances' => $cr->findCondoleances($memorial),'consultedInCategorie'=> $consultedInCategorie]),
                    // 'content' => "bravo",
                ]);
             }

            $this->addFlash("success","La condoléance a bien été modifiée");

            
            return $this->redirectToRoute(
                'show_memorial',
                ['id' => $memorial->getId()]
            );  
        }else{
            // if($request->isXmlHttpRequest()){
                // Si c'est le cas on renvoie du JSON
                return new JsonResponse([
                    'content' => "ca n'a pas fonctionné"

                ]);
            // }            
        }





    }


    #[Route('/memorial/{idMemorial}/galerie/delete/{id}', name: 'remove_photo')]
    #[Route('/memorial/{idCategorie}/{idMemorial}/galerie/delete/{id}', name: 'remove_photo_categorie')]
    #[ParamConverter("memorial", options: ["mapping" => ["idMemorial" => "id"]])]
    #[ParamConverter("image", options: ["mapping" => ["id" => "id"]])]
    #[ParamConverter("categorie", options: ["mapping" => ["idCategorie" => "id"]])]
    #[Security("is_granted('ROLE_USER') and user === memorial.getAuteur()", message:"Accès non autorisé.")]
    public function removePhotoGalerie(PhotoRepository $pr, Photo $photo, AnimalMemorial $memorial, CategorieAnimal $categorie = null, UploaderService $uploaderService)
    {

        $photo = $pr->find($photo->getId());
        $folder = 'imgGalerie';
        $uploaderService->delete($photo->getPhoto(),$folder);
        $pr->remove($photo, $flush = true);

        $this->addFlash('notice', 'La photo a été supprimée de la galerie');

        if(!$categorie){
            return $this->redirectToRoute(
                'show_memorial',
                ['id' => $memorial->getId()],
            );            
        }

        return $this->redirectToRoute(
            'show_memorial_categorie',
            ['id' => $memorial->getId(),
            'idCategorie' => $categorie->getId()]
        );  
    }

}
