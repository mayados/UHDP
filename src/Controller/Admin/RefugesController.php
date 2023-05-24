<?php

namespace App\Controller\Admin;

use App\Entity\Refuge;
use App\Form\RefugeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RefugeController extends AbstractController
{

    // #[Route('/admin/refuges/liste', name: 'app_admin_refuges_liste')]
    // public function findReported(Request $request): Response
    // {
    //     // return $this->render('admin/messagerie/messages_signales.html.twig', [
    //     //     'messagesSignales' => $mr->findPaginatedSignales($request->query->getInt('page',1)),
    //     // ]); 
    // }

    #[Route('/admin/refuges/add', name: 'app_admin_refuges_add')]
    #[Route('/admin/refuges/edit/{id}', name: 'edit_refuge')]
    public function addRefuge(Refuge $refuge = null, Request $request, ManagerRegistry $doctrine): Response
    {

        $edit = false;
        if($refuge){
            $edit = true;
        // CREATION 
        }elseif(!$refuge){
            $refuge = new Refuge();      
        }else{
            return $this->redirectToRoute('app_admin_refuges_liste');
        }

        $form = $this->createForm(RefugeType::class, $refuge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $refuge = $form->getData();            
            $entityManager = $doctrine->getManager();
            $entityManager->persist($refuge);
            $entityManager->flush();

            ($edit)?$this->addFlash('success', 'Le refuge a été modifié avec succès'):$this->addFlash('success', 'Le refuge a été créé avec succès');

            return $this->redirectToRoute('app_admin_refuges_add');
        }

        return $this->render('memorial/add.html.twig', [
            'formAddRefuge' => $form->createView(),
            'edit' => $edit,
            'refuge' => $refuge
        ]);     

    }

    
}