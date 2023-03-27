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

    // Les messages d'une conversation
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
        ->select('me.pseudo as expediteur','me.id as idExp')
        ->where('m.destinataire = :user')  
        ->andWhere('m.is_read = 0')    
        ->setParameter('user',$user)
        ->orderBy('m.dateCreation','DESC')
        ->groupBy('m.expediteur')
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

    public function findConversationsNonClassees($user)
    {
        // Aller dans la collection de messages reçus où is_read = 1 ET où l'expediteur n'est pas dans la liste des destinataires
        // Je dois sélectionner tous mes destinataires
        // Je trouve ceux qui ne sont pas dans cette liste ET où je suis destinataire ET is_read = 1
        // return $this->createQueryBuilder('m')  
        // ->join('m.expediteur', 'me')    
        // ->where('m.destinataire = :user')  
        // ->andWhere('m.is_read = 1')    
        // ->setParameter('user',$user)
        // ->getQuery()
        // ->getResult()
    //    ;


    $em = $this->getEntityManager();
    $sub = $em->createQueryBuilder();

    //Requête en deux temps

    $qb = $sub;
    $qb->select('md.id')
    ->from('App\Entity\Message', 'm')
    ->leftJoin('m.destinataire', 'md')
    ->where('m.expediteur = :user');
    // ->setParameter('user',$user);
    
    $sub = $em->createQueryBuilder();
    /* Sélectionner tous les users qui ne sont pas (NOT IN) le résultat précédent*/
    $sub->select('u.pseudo','u.id')
    ->from('App\Entity\User', 'u')
    ->leftJoin('u.messagesEnvoyes', 'me')
    // Où expr() est un expressionBuilder (sert à utiliser les conditions comme notIn)  les users dont l'id n'est pas dans la requête précédente 
    ->where($sub->expr()->notIn('u.id', $qb->getDQL()))
    ->andWhere('me.destinataire = :user')
    ->setParameter('user',$user);
    // ->orderBy('u.pseudo');

    $query = $sub->getQuery();
    return $query->getResult();

    }

    public function findCorrespondants($user)
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.destinataire','md')
            ->select('md.pseudo as pseudo','md.id')
            ->where('m.expediteur = :user')
            ->setParameter('user',$user)
            ->groupBy('pseudo')
            ->orderBy('m.dateCreation','DESC')
            ->getQuery()
            ->getResult()
        ;
    }

}
