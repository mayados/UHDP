<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_USER')]
class ReportController extends AbstractController
{
    #[Route('/report/memorial/{id}', name: 'app_report_memorial')]
    public function reportMemorial(): Response
    {

        /* On vérifie si le mémorial est dans la collection du user. Si c 'est le cas, on remove l'instance de classe ReportMmemorial */

        /* S'il n'est pas, on crée une nouvelle instance de classe */

        return $this->render('report/index.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
}
