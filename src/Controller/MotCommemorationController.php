<?php

namespace App\Controller;

use App\Form\MotType;
use App\Entity\MotCommemoration;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\MotCommemorationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MotCommemorationController extends AbstractController
{
    #[Route('/mot/commemoration', name: 'app_mot_commemoration')]
    public function index(MotCommemorationRepository $mcr, ManagerRegistry $doctrine, Request $request): Response
    {
        if($this->getUser()){
            // On trouve tous les mots par ordre décroissant pour afficher le dernier écrit au-dessus
            $mots = $mcr->findAllPaginated($request->query->getInt('page',1));

            // On affiche le formulaire d'ajout de mot uniquement à un utilisateur CONNECTE et VERIFIE
            if ($this->getUser() && $this->getUser()->isVerified()) {
                // On veut afficher le formulaire pour ajouter un mot depuis cette même page
                $mot = new MotCommemoration();
                $date = new \DateTime();     
                $form = $this->createForm(MotType::class, $mot);
                $form->handleRequest($request); 

                if ($form->isSubmitted() && $form->isValid()) {
                    $mot = $form->getData();  
                    $mot->setAuteur($this->getUser());
                    $mot->setDateCreation($date);
                    $entityManager = $doctrine->getManager();
                    $entityManager->persist($mot);
                    $entityManager->flush();     
                    
                    if($request->isXmlHttpRequest()){
                        // Si c'est le cas on renvoie du JSON
                        return new JsonResponse([
                            'content' => $this->renderView('_partials/_mots.html.twig', ['formAddMot' => $form->createView(), 'mots' => $mcr->findAllPaginated($request->query->getInt('page',1))]),
                            'pagination' => $this->renderView('_partials/_pagination.html.twig', ['elementPagine' => $mcr->findAllPaginated($request->query->getInt('page',1)) ])
                        ]);
                    }

                    return $this->redirectToRoute(
                        'app_mot_commemoration',
                    );
                }else{
                    // Si le formulaire n'est pas valide et qu'il s'agit d'une requête AJAX
                    if($request->isXmlHttpRequest()){
                        $errorMessage ="";
                        // la fonction getErrors() permet d'obtenir une instance de l'objet FormErrorIterator, pour obtenir le message il faut donc faire appel, pour chaque erreur qu'il pourrait y avoir, à la fonction getMessage()
                        $errors = $form['mot']->getErrors();
                        foreach ($errors as $error) {
                            $errorMessage = $error->getMessage();
                        };

                        // Si c'est le cas on renvoie du JSON
                        return new JsonResponse([
                            'content' => $this->renderView('_partials/_mots.html.twig', ['formAddMot' => $form->createView(), 'mots' => $mcr->findAllPaginated($request->query->getInt('page',1))]),
                            'error' => $errorMessage,
                        ]);
                    }
                }

                return $this->render('mot_commemoration/mur.html.twig', [
                    'mots' => $mots,
                    'formAddMot' => $form->createView(),
                ]);                  
            }

            // Si l'utilisateur n'est pas vérifié, on render juste les mots
            return $this->render('mot_commemoration/mur.html.twig', [
                'mots' => $mots,
            ]);      
          
        }

        return $this->render('mot_commemoration/nonConnecte.html.twig');  

    }

    #[Route('/mot/commemoration/remove/mot/{id}', name: 'remove_mot')]
    #[Security("is_granted('ROLE_USER') and user === mot.getAuteur()", message:"Accès non autorisé.")]
    public function removeMot(MotCommemorationRepository $mcr, MotCommemoration $mot, Request $request)
    {

        $mot = $mcr->find($mot->getId());        
        $mcr->remove($mot, $flush = true);

        return new JsonResponse([
            'content' => $this->renderView('_partials/_mots.html.twig', ['mots' => $mcr->findAllPaginated($request->query->getInt('page',1))]),

        ]);     
        // return $this->redirectToRoute('app_mot_commemoration');            

    }

    #[Route('/mot/commemoration/edit/mot/{id}', name: 'edit_mot')]
    #[Security("is_granted('ROLE_USER') and user === mot.getAuteur()", message:"Accès non autorisé.")]
    public function editMot(MotCommemoration $mot, MotCommemorationRepository $mcr ,ManagerRegistry $doctrine,Request $request){

        // On récupère le token généré dans le formulaire
        $submittedToken = $request->request->get('token');
        $texteTest = $request->request->get('texte');

        if (isset($_POST) && $this->isCsrfTokenValid('modify-item', $submittedToken)) {
            $entityManager = $doctrine->getManager();
            $texte = $request->request->get('texte');
            $date = $mot->getDateCreation();
            $auteur = $mot->getAuteur();
            $mot->setDateCreation($date);
            $mot->setAuteur($auteur);
            $mot->setMot($texte);
            $entityManager->persist($mot);
            $entityManager->flush();

            if($request->isXmlHttpRequest()){
                // Si c'est le cas on renvoie du JSON
                return new JsonResponse([
                    'content' => $this->renderView('_partials/_mots.html.twig', ['mots' => $mcr->findAllPaginated($request->query->getInt('page',1))]),
                    // 'content' => "bravo",
                ]);
             }
            
            // $this->addFlash("success","Le mot a bien été modifié");

            
            // return $this->redirectToRoute(
            //     'app_mot_commemoration'
            // );  
        }else{
            // if($request->isXmlHttpRequest()){
                // Si c'est le cas on renvoie du JSON
                return new JsonResponse([
                    'content' => "ca n'a pas fonctionné"

                ]);
            // }            
        }


    }

}
