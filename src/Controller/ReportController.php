<?php

namespace App\Controller;

use App\Entity\AnimalMemorial;
use App\Entity\ReportMemorial;
use App\Repository\ReportMemorialRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
class ReportController extends AbstractController
{
    #[Route('/report/memorial/{id}', name: 'app_report_memorial')]
    public function reportMemorial(AnimalMemorial $memorial, ReportMemorialRepository $rpm, Request $request): Response
    {
        
        $user = $this->getUser();

        $signaleur = $rpm->findSignaleurMemorial($user,$memorial);

        // Met la mauvaise heure : deux heures de moins que l'heure actuelle
        $now = new \DateTimeImmutable();

        if($signaleur != null){

            // dd($signaleur);
            $rpm->remove($signaleur, $flush = true);
            // Signifie que le user a déjà signalé ce mémorial, donc on dé-signal

        }else{
            $report = new ReportMemorial();
            $report->setSignaleur($user);
            $report->setMemorial($memorial);
            $report->setDateCreation($now);
            $rpm->save($report, $flush = true);
            // dd("Je suis null");
            // On crée un signalement
        }

        return $this->redirectToRoute(
            'show_memorial',
            ['id' => $memorial->getId()]
        );   

        // $reports = $memorial->getReports();
        // /* On vérifie si le mémorial est dans la collection du user. Si c 'est le cas, on remove l'instance de classe ReportMmemorial */
        // foreach($reports as $report ){
        //     // return $report;
        //     dd($report->getSignaleur()->getPseudo());
        // }
        /* S'il n'est pas, on crée une nouvelle instance de classe */

        // return $this->render('report/index.html.twig', [
        //     'controller_name' => 'ReportController',
        // ]);
    }
}
