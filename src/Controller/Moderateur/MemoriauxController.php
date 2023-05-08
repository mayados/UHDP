<?php

namespace App\Controller\Moderateur;

use App\Entity\Photo;
use App\Form\MemorialType;
use App\Entity\Condoleance;
use App\Form\CategorieType;
use App\Form\CondoleanceType;
use App\Entity\AnimalMemorial;
use App\Entity\CategorieAnimal;
use App\Service\UploaderService;
use App\Repository\PhotoRepository;
use App\Repository\CondoleanceRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\AnimalMemorialRepository;
use App\Repository\ReportMemorialRepository;
use App\Repository\CategorieAnimalRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ReportCondoleanceRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


#[IsGranted('ROLE_MODERATEUR_MEMORIAUX', statusCode: 403, message: 'Il faut être modérateur pour accéder à la messagerie')]
class MemoriauxController extends AbstractController
{

    /* Liste des mémoriaux */
    #[Route('/moderateur/memoriaux', name: 'app_moderateur_memoriaux')]
    public function findMemoriauxNonSignales(AnimalMemorialRepository $amr, Request $request): Response
    {

        return $this->render('moderateur/memoriaux/memoriaux.html.twig', [
            'memoriaux' => $amr->findPaginatedMemoriauxNonSignales($request->query->getInt('page',1)),
        ]);
    }

    /* Liste des mémoriaux signalés */
    #[Route('/moderateur/memoriaux/signales', name: 'app_moderateur_memoriaux_signales')]
    public function findMemoriauxSignales(ReportMemorialRepository $rmr, Request $request): Response
    {

        return $this->render('moderateur/memoriaux/memoriaux_signales.html.twig', [
            'memoriaux' => $rmr->findPaginatedSignales($request->query->getInt('page',1)),
        ]);
    }

    /* Liste des mots de condoléance */
    #[Route('/moderateur/memoriaux/condoleances', name: 'app_moderateur_condoleances')]
    public function findCondoleancesNonSignalees(CondoleanceRepository $cr, Request $request): Response
    {

        return $this->render('moderateur/memoriaux/condoleances.html.twig', [
            'condoleances' => $cr->findPaginatedCondoleancesNonSignalees($request->query->getInt('page',1)),
        ]);
    }

    #[Route('/moderateur/memoriaux/condoleances/signalees', name: 'app_moderateur_condoleances_signalees')]
    public function findCondoleancesSignalees(ReportCondoleanceRepository $rcr, Request $request): Response
    {

        return $this->render('moderateur/memoriaux/condoleances.html.twig', [
            'condoleances' => $rcr->findPaginatedSignalees($request->query->getInt('page',1)),
        ]);
    }

    #[Route('/moderateur/memoriaux/{id}', name: 'app_moderateur_memorial_show')]
    public function showMemorial(AnimalMemorial $memorial, Request $request, UploaderService $uploaderService, ManagerRegistry $doctrine): Response
    {
        
        return $this->render('moderateur/memoriaux/showMemorial.html.twig', [
            'memorial' => $memorial,
        ]);
    }

    #[Route('/moderateur/memorial/remove/{id}', name: 'app_moderateur_memorial_remove')]
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

            return $this->redirectToRoute("app_moderateur_memoriaux_signales");            

    }

    #[Route('/moderateur/memoriaux/condoleance/{id}', name: 'app_moderateur_condoleance_show')]
    public function showCondoleance(Condoleance $condoleance, Request $request, ManagerRegistry $doctrine): Response
    {

        return $this->render('moderateur/memoriaux/showCondoleance.html.twig', [
            'condoleance' => $condoleance,
        ]);
    }

    #[Route('/moderateur/memorial/{idMemorial}/galerie/delete/{id}', name: 'app_moderateur_remove_photo')]
    #[ParamConverter("memorial", options: ["mapping" => ["idMemorial" => "id"]])]
    #[ParamConverter("image", options: ["mapping" => ["id" => "id"]])]
    public function removePhotoGalerie(PhotoRepository $pr, Photo $photo, AnimalMemorial $memorial, UploaderService $uploaderService)
    {

        $photo = $pr->find($photo->getId());
        $folder = 'imgGalerie';
        $uploaderService->delete($photo->getPhoto(),$folder);
        $pr->remove($photo, $flush = true);

        $this->addFlash('notice', 'La photo a été supprimée de la galerie');

        return $this->redirectToRoute(
            'app_moderateur_memorial_show',
            ['id' => $memorial->getId()],
        );
    }

    #[Route('/moderateur/condoleance/remove/{idMemorial}/{id}', name: 'app_moderateur_condoleance_remove')]
    #[ParamConverter("memorial", options: ["mapping" => ["idMemorial" => "id"]])]
    #[ParamConverter("condoleance", options: ["mapping" => ["id" => "id"]])]
    public function removeCondoleance(CondoleanceRepository $cr, Condoleance $condoleance, AnimalMemorial $memorial, AnimalMemorialRepository $amr)
    {
        $condoleance = $cr->find($condoleance->getId());

        $cr->remove($condoleance, $flush = true);
        $memorial = $amr->find($memorial->getId());

        $this->addFlash('notice', "La condoléance a été supprimée");

        return $this->redirectToRoute(
            'app_moderateur_condoleances'
        );            
    }

    #[Route('/moderateur/condoleance/reports/remove/{id}', name: 'app_moderateur_condoleance_remove_reports')]
    public function removeReportsCondoleance(ReportCondoleanceRepository $rcr, Condoleance $condoleance)
    {
        $idCondoleance = $condoleance->getId();
        $reports = $rcr->findReportsByCondoleance($idCondoleance);

        foreach($reports as $report)
        {
            $rcr->remove($report, $flush = true);
        }

        $this->addFlash('notice', "Les signalements ont été supprimés");

        return $this->redirectToRoute(
            'app_moderateur_condoleance_show',
            ['id' => $condoleance->getId()]
        );          

    }

    #[Route('/moderateur/memorial/reports/remove/{id}', name: 'app_moderateur_memorial_remove_reports')]
    public function removeReportsMemorial(ReportMemorialRepository $rmr, AnimalMemorial $memorial)
    {
        $idMemorial = $memorial->getId();
        $reports = $rmr->findReportsByMemorial($idMemorial);

        foreach($reports as $report)
        {
            $rmr->remove($report, $flush = true);
        }

        $this->addFlash('notice', "Les signalements ont été supprimés");

        return $this->redirectToRoute(
            'app_moderateur_memorial_show',
            ['id' => $memorial->getId()]
        );          

    }

    
}
