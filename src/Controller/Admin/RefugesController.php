<?php

namespace App\Controller\Admin;

use App\Entity\Refuge;
use App\Form\RefugeType;
use App\Repository\RefugeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RefugesController extends AbstractController
{

    #[Route('/admin/refuges/liste', name: 'app_admin_refuges_liste')]
    public function displayRefuges(RefugeRepository $rr,Request $request): Response
    {

        $refuges = $rr->findPaginatedRefugesForAdmin($request->query->getInt('page',1));

        return $this->render('admin/refuges/refuges.html.twig', [
            'refuges' => $refuges,
        ]); 
    }

    #[Route('/admin/refuges/show/{id}', name: 'app_admin_show_refuge')]
    public function showRefuge(Refuge $refuge, Request $request, ManagerRegistry $doctrine): Response
    {

        $form = $this->createForm(RefugeType::class, $refuge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $refuge = $form->getData();            
            $entityManager = $doctrine->getManager();
            $entityManager->persist($refuge);
            $entityManager->flush();

            $this->addFlash('success', 'Le refuge a été modifié avec succès');

            return $this->redirectToRoute('app_admin_show_refuge',[
                'id' => $refuge->getId(),
            ]);
        }

        return $this->render('admin/refuges/showRefuge.html.twig', [
            'formEditRefuge' => $form->createView(),
            'refuge' => $refuge
        ]);     

    }

    #[Route('/admin/refuges/add', name: 'app_admin_refuges_add')]
    public function addRefuge(Request $request, ManagerRegistry $doctrine): Response
    {

        $refuge = new Refuge();

        $form = $this->createForm(RefugeType::class, $refuge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $refuge = $form->getData();            
            $entityManager = $doctrine->getManager();
            $entityManager->persist($refuge);
            $entityManager->flush();

            $this->addFlash('success', 'Le refuge a été ajouté avec succès');

            return $this->redirectToRoute('app_admin_refuges_add');
        }

        return $this->render('admin/refuges/add.html.twig', [
            'formAddRefuge' => $form->createView(),
            'refuge' => $refuge
        ]);     

    }

    #[Route('/admin/refuge/remove/{id}', name: 'app_admin_refuge_remove')]
    public function removeRefuge(Refuge $refuge, RefugeRepository $rr ,Request $request, ManagerRegistry $doctrine)
    {

        $rr->remove($refuge, $flush = true);

        $this->addFlash('success','Le refuge a été supprimé avec succès');

        return $this->redirectToRoute('app_admin_refuges_liste');     

    }

    
}