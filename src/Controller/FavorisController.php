<?php

namespace App\Controller;

use App\Entity\BelleHistoire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavorisController extends AbstractController
{
    #[Route('/favoris/belleHistoire/{id}', name: 'app_favorisHistoire')]
    public function favorisHistoire(BelleHistoire $histoire, EntityManagerInterface $manager): Response
    {

        $user = $this->getUser();

        // On vérifie si le User est contenu dans la collection de favoris d'utilisateurs de l'histoire en question
        if($histoire->isFavoritedByUser($user))
        {
            // S'il l'a déjà mis en favoris, on lui dit de remove le favoris
            $histoire->removeFavori($user);
            $manager->flush();

            // On précise les datas que l'on souhaite envoyer au json
            return $this->json([
                'message' => 'Le favoris a été supprimé.',
            ]);
        }

        $histoire->addFavori($user);
        $manager->flush();

        return $this->json([
            'message' => 'Le favoris a été ajouté.',
        ]);
    }
}
