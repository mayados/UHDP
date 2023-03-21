<?php

namespace App\Controller;

use App\Entity\BelleHistoire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LikeController extends AbstractController
{
    #[Route('/like/belleHistoire/{id}', name: 'app_likeHistoire')]
    public function likeHistoire(BelleHistoire $histoire, EntityManagerInterface $manager): Response
    {

        $user = $this->getUser();

        // On vérifie si le User est contenu dans la collection de likes d'utilisateurs de l'histoire en question
        if($histoire->isLikedByUser($user))
        {
            // Si il a déjà liké, on lui dit de remove le like
            $histoire->removeLike($user);
            $manager->flush();

            // On précise les datas que l'on souhaite envoyer au json
            return $this->json([
                'message' => 'Le like a été supprimé.',
                'nbLike' => $histoire->howManyLikes()
            ]);
        }

        $histoire->addLike($user);
        $manager->flush();

        return $this->json([
            'message' => 'Le like a été ajouté.',
            'nbLike' => $histoire->howManyLikes()
        ]);
    }
}
