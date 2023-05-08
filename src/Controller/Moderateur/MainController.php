<?php

namespace App\Controller\Moderateur;

use App\Entity\User;
use App\Form\CategorieType;
use App\Entity\CategorieAnimal;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CategorieAnimalRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

#[Security("is_granted('ROLE_MODERATEUR_HISTOIRES') or is_granted('ROLE_MODERATEUR_FORUM') or is_granted('ROLE_MODERATEUR_MEMORIAUX') or is_granted('ROLE_MODERATEUR_COMMEMORATION')", statusCode: 403)]
class MainController extends AbstractController
{
    #[Route('/moderateur', name: 'app_moderateur')]
    public function index(): Response
    {
        return $this->render('moderateur/index.html.twig');
    }
    
}
