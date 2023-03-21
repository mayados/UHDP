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

    // public function findConversations($user)
    // {

    //     // fonctionne, mais affiche des doublons car les deux requêtes ne sont pas séparées
    //     $qb =  $this->createQueryBuilder('m')
    //     ->join('m.destinataire','md')  
    //     ->join('m.expediteur', 'me')      
    //     ->select(['m','md','md.pseudo as destinataire_pseudo','me.pseudo as expediteur_pseudo','md.id as destinataire','me.id as expediteur'])
    //     ->where('m.expediteur = 1')    
    //     ->orWhere('m.destinataire = 1')    
    //     ->distinct(true)
    //     ->groupBy('destinataire')
    //     // ->addGroupBy('expediteur')
    //    ;
    //    $query = $qb->getQuery();
    //    return $query->getResult();
    // }

    public function findSentMessages($user)
    {

    //     $em = $this->getEntityManager();
    //     $sub = $em->createQueryBuilder();
    //     $qb = $sub;
    //     $qb->select(['me.texte'])
    //     ->from('App\Entity\User','u')
    //     ->where('u.id = :user')
    //     ->setParameter('user',$user)
    //     ->join('u.messagesEnvoyes','me')   
    //     ->orderBy('me.id','DESC')
    //     ->distinct(true)        
    //    ;
    //    $query = $sub->getQuery();
    //    return $query->getResult();

        $qb =  $this->createQueryBuilder('m')
        ->join('m.destinataire','md')  
        ->join('m.expediteur', 'me')      
        ->select(['m.texte','m.dateCreation','md.pseudo as destinataire'])
        ->where('m.expediteur = :user')  
        ->setParameter('user',$user)   
        // ->distinct(true)
        ->orderBy('m.dateCreation','DESC')
       ;
       $query = $qb->getQuery();
       return $query->getResult();

    }

    public function findreceivedMessages($user)
    {

        $qb =  $this->createQueryBuilder('m')
        ->join('m.destinataire','md')  
        ->join('m.expediteur', 'me')      
        ->select(['m.texte','me.pseudo as expediteur','m.dateCreation'])
        ->where('m.destinataire = :user')  
        ->setParameter('user',$user)   
        ->orderBy('m.dateCreation','DESC')
       ;
       $query = $qb->getQuery();
       return $query->getResult();

    }

    public function findMessagesByConversation($me,$user)
    {
        $parameters = array(
            'me' => $me, 
            'user' => $user
        );

        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();
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

    public function findUnreadMessages($user)
    {
        return $this->createQueryBuilder('m')  
        ->join('m.expediteur', 'me')    
        ->select('m.texte, me.pseudo as expediteur','m.dateCreation')
        ->where('m.destinataire = :user')  
        ->andWhere('m.is_read = 0')    
        ->setParameter('user',$user)
        ->getQuery()
        ->getResult()
       ;
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
