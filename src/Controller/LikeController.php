<?php

namespace App\Controller;

use App\Entity\AnimalMemorial;
use App\Entity\BelleHistoire;
use App\Entity\CommentBelleHistoire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


#[IsGranted('ROLE_USER')]
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

    #[Route('/like/commentBelleHistoire/{id}', name: 'app_likeComment')]
    public function likeComment(CommentBelleHistoire $comment, EntityManagerInterface $manager): Response
    {

        $user = $this->getUser();

        // On vérifie si le User est contenu dans la collection de likes d'utilisateurs du commentaire en question
        if($comment->isLikedByUser($user))
        {
            // Si il a déjà liké, on lui dit de remove le like
            $comment->removeLike($user);
            $manager->flush();

            // On précise les datas que l'on souhaite envoyer au json
            
            return $this->json([
                'message' => 'Le like de commentaire a été supprimé.',
                'nbLike' => $comment->howManyLikes()
            ]);

        }

        $comment->addLike($user);
        $manager->flush();

        return $this->json([
            'message' => 'Le like de commentaire a été ajouté.',
            'nbLike' => $comment->howManyLikes()
        ]);

        
    }

    #[Route('/like/memorial/{id}', name: 'app_showSoutient')]
    public function showSoutient(AnimalMemorial $memorial, EntityManagerInterface $manager): Response
    {

        $user = $this->getUser();

        // On vérifie si le User est contenu dans la collection de likes d'utilisateurs du commentaire en question
        if($memorial->isSupportedByUser($user))
        {
            // Si il a déjà liké, on lui dit de remove le like
            $memorial->removeSoutient($user);
            $manager->flush();

            // On précise les datas que l'on souhaite envoyer au json
            return $this->json([
                'message' => 'Le like de commentaire a été supprimé.',
                'nbLike' => $memorial->howManySupports()
            ]);
        }

        $memorial->addSoutient($user);
        $manager->flush();

        return $this->json([
            'message' => 'Le like de commentaire a été ajouté.',
            'nbLike' => $memorial->howManySupports()
        ]);
    }
}
