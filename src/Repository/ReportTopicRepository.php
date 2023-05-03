<?php

namespace App\Repository;

use App\Entity\ReportTopic;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<ReportTopic>
 *
 * @method ReportTopic|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportTopic|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportTopic[]    findAll()
 * @method ReportTopic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportTopicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, ReportTopic::class);
    }

    public function save(ReportTopic $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ReportTopic $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findSignaleurTopic($user, $topic){

        // Renvoie un array 

        $parameters = [
            'user' => $user,
            'topic' => $topic,
        ];

        return $this->createQueryBuilder('r')
        ->where('r.signaleur = :user')
        ->andWhere('r.topic = topic')
        ->setParameters($parameters)
        ->getQuery()
        // ->getResult()
        ->getOneOrNullResult();

    }

    public function findPaginatedTopicsSignales(int $page): PaginationInterface
    {

        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        //Requête en deux temps

        $qb = $sub;
        $qb->select('to.id')
        ->from('App\Entity\ReportTopic', 'rt')
        ->join('rt.topic', 'to');
        
        $sub = $em->createQueryBuilder();
        /* Sélectionner tous les topics qui ne sont pas (NOT IN) le résultat précédent*/
        // Cette deuxieme requete est effectuée afin de récupérer la totalité de l'entité Topic, notamment pour accéder à ses méthodes
        $sub->select('t')
        ->from('App\Entity\Topic', 't')
        ->where($sub->expr()->In('t.id', $qb->getDQL()))
        // Nous trions du plus ancien en premier au plus récent
        ->orderBy('t.dateCreation','ASC');

        $query = $sub->getQuery();
        $data = $query->getResult();
        $topicsSignales = $this->paginatorInterface->paginate($data,$page,20);

        return $topicsSignales;  

    }

//    /**
//     * @return ReportTopic[] Returns an array of ReportTopic objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ReportTopic
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
