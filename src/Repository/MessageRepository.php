<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Message>
 *
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function save(Message $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Message $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findConversations($user)
    {

        //je veux tous les messages où je suis expéditeur OU tous les messages où je suis destinataire
    //     return $this->createQueryBuilder('m')
    //     ->select('m')
    //     ->join('m.expediteur','e')
    //     ->distinct()
    //     ->andWhere('e = :user')
    //     ->orWhere('m.destinataire = :user')
    //     ->setParameter('user', $user)
    //     // ->groupBy('m.expediteur')
    //     ->orderBy('m.dateCreation', 'ASC')
    //     ->getQuery()
    //     ->getResult()
    //    ;

        // fonctionne, mais il faut séparer les requêtes
        $qb =  $this->createQueryBuilder('m')
        ->join('m.destinataire','md')  
        ->join('m.expediteur', 'me')      
        ->select(['m','md','md.pseudo as destinataire_pseudo','me.pseudo as expediteur_pseudo','md.id as destinataire','me.id as expediteur'])
        ->where('m.expediteur = 1')    
        ->orWhere('m.destinataire = 1')    
        ->distinct(true)
        ->groupBy('destinataire')
        // ->addGroupBy('expediteur')
       ;
       $query = $qb->getQuery();
       return $query->getResult();

        // Essai requête séparée
        // $em = $this->getEntityManager();
        // $sub = $em->createQueryBuilder();

        // //Requête en deux temps
        // // Je ne reçois que l'expéditeur, pas les messages que j'ai envoyés
        // // $qb est égal à la création d'une requête + la connexion à Doctrine
        // $qb = $sub;
        // $qb->select(['m','md','me.pseudo as expediteur_pseudo','md.pseudo as destinataire_pseudo','md.id as destinataire','me.id as expediteur'])
        // ->from('App\Entity\Message', 'm')
        // ->join('m.expediteur', 'me') 
        // ->join('m.destinataire', 'md') 
        // ->where('m.expediteur = :user') 
        // // ->orWhere('m.destinataire = :user') 
        // ->setParameter('user',$user)
        // ->groupBy('destinataire');
        // // ->addGroupBy('expediteur');
        // // Il faudra que je vérifie si l'expéditeur n'est pas dans le résultat précédent des destinataires
        
        // $sub = $em->createQueryBuilder();
        // $sub->select(['mess','messe.pseudo as expediteur_pseudo','messd.id as destinataire','messe.id as expediteur'])
        // // On donne l'allias mess à l'entité Message
        // ->from('App\Entity\Message', 'mess')
        // ->join('mess.expediteur', 'messe') 
        // ->join('mess.destinataire', 'messd') 
        // ->where('mess.destinataire = :user')
        // ->setParameter('user',$user)
        // ->andWhere($sub->expr()->notIn('destinataire', $qb->getDQL()))
        // // Requête préparée -> on protège contre l'injection SQL
    // ;
    // $query = $sub->getQuery();
    //     return $query->getResult();
    }

    public function findMessagesByConversation($me,$user)
    {
        $parameters = array(
            'me' => $me, 
            'user' => $user
        );
        //Je dois retrouver tous les messages où je suis expédteur et l'autre destinataire OU tous les messages où je suis destinataire et l'autre expéditeur
        $qb =  $this->createQueryBuilder('m')  
        ->select(['m'])
        ->where('m.expediteur = :me OR m.expediteur = :user')    
        ->andWhere('m.destinataire = :me OR m.destinataire = :user')    
        ->distinct(true)
        ->setParameters($parameters)
        ->orderBy('m.dateCreation','ASC')
       ;
       $query = $qb->getQuery();
       return $query->getResult();
    }

    // Le but va être de récupérer les messages non lus pour pouvoir les mettre sous forme de notification
    public function findNonLus($user)
    {
        return $this->createQueryBuilder('m')  
        ->select('count(m.is_read)')
        ->where('m.destinataire = :user')  
        ->andWhere('m.is_read = 0')    
        ->setParameter('user',$user)
        ->getQuery()
        ->getResult()
       ;

    }

//    /**
//     * @return Message[] Returns an array of Message objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Message
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
