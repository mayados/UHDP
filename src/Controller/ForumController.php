<?php

namespace App\Controller;

use DateTimeZone;
use App\Entity\Post;
use App\Entity\Topic;
use App\Form\PostType;
use App\Form\SearchTopicType;
use App\Form\TopicType;
use App\Service\SluggerService;
use App\Repository\PostRepository;
use App\Repository\TopicRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ForumController extends AbstractController
{
    #[Route('/forum', name: 'app_forum')]
    public function index(TopicRepository $tr, Request $request): Response
    {

        if($this->getUser()){
            $topics = $tr->findPaginatedTopics($request->query->getInt('page',1));

            $form = $this->createForm(SearchTopicType::class);
            $searchTopic = $form->handleRequest($request);   
            if($form->isSubmitted() && $form->isValid()){
                $mot = strtolower($searchTopic->get('mot')->getData());
                $topics = $tr->searchTopic($mot,$request->query->getInt('page',1));
            }
            
            return $this->render('forum/index.html.twig', [
                'topics' => $topics,
                'form' => $form->createView(),
            ]);            
        }

        return $this->render('forum/nonConnecte.html.twig');       

    }

    #[Route('/topic/{slug}', name: 'show_topic')]
    #[Security("is_granted('ROLE_USER')")]
    public function showTopic(ManagerRegistry $doctrine, TopicRepository $tr, Topic $topic, PostRepository $pr, Request $request): Response
    {

        $topic = $tr->find($topic->getId());
        $posts = $pr->findPaginatedPosts($request->query->getInt('page',1),$topic);    

        // Si l'utilisateur est connecté et vérifié
        if ($this->getUser()->isVerified()) {
            
            $post = new Post();
            $date = date_timezone_set(new \DateTime(),new DateTimeZone('Europe/Paris'));
            // $date = new \DateTime();
            $form = $this->createForm(PostType::class, $post);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $post = $form->getData();
                $post->setAuteur($this->getUser());
                $post->setTopic($topic);
                $post->setDateCreation($date);
                $topic->addPost($post);
                $entityManager = $doctrine->getManager();
                $entityManager->persist($post);
                $entityManager->flush();

                if($request->isXmlHttpRequest()){
                    // Si c'est le cas on renvoie du JSON
                    return new JsonResponse([
                        'content' => $this->renderView('_partials/_posts.html.twig', ['topic' => $topic,'formAddPost' => $form->createView(), 'posts' => $pr->findPaginatedPosts($request->query->getInt('page',1),$topic)]),
                        'pagination' => $this->renderView('_partials/_pagination.html.twig', ['elementPagine' => $pr->findPaginatedPosts($request->query->getInt('page',1),$topic) ])

                    ]);
                }

                return $this->redirectToRoute(
                    'show_topic',
                    ['slug' => $topic->getSlug()]
                );
            }else{
                                // Si le formulaire n'est pas valide et qu'il s'agit d'une requête AJAX
                if($request->isXmlHttpRequest()){
                    $errorMessage ="";
                    // la fonction getErrors() permet d'obtenir une instance de l'objet FormErrorIterator, pour obtenir le message il faut donc faire appel, pour chaque erreur qu'il pourrait y avoir, à la fonction getMessage()
                    $errors = $form['texte']->getErrors();
                    foreach ($errors as $error) {
                        $errorMessage = $error->getMessage();
                    };

                    // Si c'est le cas on renvoie du JSON
                    return new JsonResponse([
                        'content' => $this->renderView('_partials/_posts.html.twig', ['topic' => $topic,'formAddPost' => $form->createView(), 'posts' => $pr->findPaginatedPosts($request->query->getInt('page',1),$topic)]),
                        'error' => $errorMessage,
                    ]);
                }
            }

            return $this->render('forum/topic.html.twig', [
                'topic' => $topic,
                'formAddPost' => $form->createView(),
                'posts' => $posts,
            ]);
        }

        // S'il y a un utilisateur et qu'il n'est pas vérifié on renvoie à la vue sans le form du post
        return $this->render('forum/topic.html.twig', [
            'topic' => $topic,
            'posts' => $posts,
        ]);            

    }

    #[Route('/forum/add', name: 'add_topic')]
    #[Route('/forum/edit/{slug}', name: 'edit_topic')]
    #[Security("is_granted('ROLE_USER') and user.isVerified() === true", message:"Accès non autorisé.")]
    public function add(ManagerRegistry $doctrine, Topic $topic = null, Request $request, SluggerService $sluggerService): Response
    {

        $edit = false;
        // CAS  de l'edit => Si le topic existe ET que l'utilisateur connecté est l'auteur du topic 
        if($topic && ($this->getUser() == $topic->getAuteur())){
            $edit = true;
            $date = $topic->getDateCreation();
            /* Nous ciblons le premier post de la collection de posts de l'entité Topic, car il correspond au message de l'auteur
            et qu'il faudra le modifier dans le cadre d'un edit, et non créer un autre post */
            $post = $topic->getPosts()[0];
            // Dans le cas d'un edit, on attribue à auteur la value de l'auteur du topic stockée en base de données (car si c'est un admin qui modifie, ce ne sera pas l'auteur)
            $auteurTopic = $topic->getAuteur();
            // CAS de la création => Si le topic n'existe pas ET que l'utilisateur courant est vérifié
        }elseif(!$topic){
            $topic = new Topic();
            $date = new \DateTime();    
            $post = new Post();   
            $auteurTopic = $this->getUser();                                 
        }else{
            // Si l'utilisateur courant n'est pas l'auteur du topic et qu'il voulait le modifier'
            return $this->redirectToRoute('app_forum');
        }
        // dd($topic->getPosts()[0]->getTexte());

        $form = $this->createForm(TopicType::class, $topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $topic = $form->getData();   
            $firstComment = $form->get('firstComment')->getData();
            $titre = $form->get('titre')->getData();
            $slug = $sluggerService->slugElement($titre);
            $post->setTexte($firstComment);
            $post->setAuteur($auteurTopic);
            $post->setTopic($topic);
            $post->setDateCreation($date);
            $topic->addPost($post);
            $topic->setSlug($slug);
            $topic->setAuteur($auteurTopic);
            $topic->setDateCreation($date); 
            $topic->setVerrouillage(0);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($topic);
            $entityManager->flush();

            ($edit)?$this->addFlash('success', "Le topic a été modifié avec succès"):$this->addFlash('success', "Le topic a été créé avec succès");

            return $this->redirectToRoute('app_forum');
        }

        return $this->render('forum/add.html.twig', [
            'formAddTopic' => $form->createView(),
            'edit' => $edit,
            'post' => $post,
        ]);            
    }

    #[Route('/topic/remove/{slug}', name: 'remove_topic')]
    #[Security("is_granted('ROLE_USER') and user === topic.getAuteur()", message:"Accès non autorisé.")]
    public function removeTopic(TopicRepository $tr, Topic $topic)
    {

            $topic = $tr->find($topic->getId());
            $tr->remove($topic, $flush = true);

            $this->addFlash('notice', 'Le topic a été supprimé');

            return $this->redirectToRoute('app_forum');            
    }

    #[Route('/post/remove/{slug}/{id}', name: 'remove_post', requirements: ['id' => '\d+'])]
    #[ParamConverter("topic", options: ["mapping" => ["slug" => "slug"]])]
    #[ParamConverter("post", options: ["mapping" => ["id" => "id"]])]
    #[Security("is_granted('ROLE_USER') and user === post.getAuteur()", message:"Accès non autorisé.")]
    public function removePost(PostRepository $pr, Post $post, Topic $topic, TopicRepository $tr, Request $request)
    {
            $post = $pr->find($post->getId());

            $pr->remove($post, $flush = true);
            
            $topic = $tr->find($topic->getId());

            return new JsonResponse([
                'content' => $this->renderView('_partials/_posts.html.twig', ['posts' => $pr->findPaginatedPosts($request->query->getInt('page',1),$topic),'topic' => $topic]),
    
            ]);       

            // $this->addFlash('notice', 'Le commentaire a été supprimé');

            // return $this->redirectToRoute(
            //     'show_topic',
            //     ['slug' => $topic->getSlug()]
            // );
    }    

    #[Route('/topic/post/edit/{id}/{slugTopic}', name: 'edit_post')]
    #[ParamConverter("commentaire", options: ["mapping" => ["id" => "id"]])]
    #[ParamConverter("topic", options: ["mapping" => ["slugTopic" => "slug"]])]
    #[Security("is_granted('ROLE_USER') and user === post.getAuteur()", message:"Accès non autorisé.")]
    public function editPost(Post $post, Topic $topic, PostRepository $pr ,ManagerRegistry $doctrine,Request $request){

        // On récupère le token généré dans le formulaire
        $submittedToken = $request->request->get('token');
        $texteTest = $request->request->get('texte');

        if (isset($_POST) && $this->isCsrfTokenValid('modify-item', $submittedToken)) {
            $entityManager = $doctrine->getManager();
            $texte = $request->request->get('texte');
            $post->setTopic($topic);
            $date = $post->getDateCreation();
            $auteur = $post->getAuteur();
            $post->setDateCreation($date);
            $post->setAuteur($auteur);
            $post->setTexte($texte);
            $entityManager->persist($post);
            $entityManager->flush();

            if($request->isXmlHttpRequest()){
                // Si c'est le cas on renvoie du JSON
                return new JsonResponse([
                    'content' => $this->renderView('_partials/_posts.html.twig', ['topic' => $topic, 'posts' => $pr->findPaginatedPosts($request->query->getInt('page',1),$topic)]),
                ]);
             }


            // $this->addFlash("success","Le post a bien été modifié");

            
            // return $this->redirectToRoute(
            //     'show_topic',
            //     ['slug' => $topic->getSlug()]
            // );  
        }
        else{
            // if($request->isXmlHttpRequest()){
                // Si c'est le cas on renvoie du JSON
                return new JsonResponse([
                    'content' => "ca n'a pas fonctionné"

                ]);
            // }            
        }


    }

    #[Route('/topic/verrouillage/{id}', name: 'verrouillage_topic')]
    #[Security("is_granted('ROLE_USER') and user === topic.getAuteur()", message:"Accès non autorisé.")]
    public function verrouillageTopic(Topic $topic, TopicRepository $tr, ManagerRegistry $doctrine)
    {

        $entityManager = $doctrine->getManager();
        $topic = $tr->find($topic->getId());
        // On vérifie s'il s'agit d'un verrouillage ou dévérouillage
        if($topic->isVerrouillage() == false){
            // On vérrouille le topic
            $topic->setVerrouillage(true);
        }else{
            // On déverouille
            $topic->setVerrouillage(false);
        }

        $entityManager->flush();

        $this->addFlash('notice' ,'Le topic est verrouillé');

         return $this->redirectToRoute(
            'show_topic',
            ['id' => $topic->getId()]
        );            
    }

}
