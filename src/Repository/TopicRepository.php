<?php

namespace App\Repository;

use App\Entity\Topic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Topic>
 *
 * @method Topic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Topic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Topic[]    findAll()
 * @method Topic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TopicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, Topic::class);
    }

    public function save(Topic $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Topic $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function searchTopic($mot,$page): PaginationInterface
    {
        if($mot != null){
            $data = $this->createQueryBuilder('t')
            ->where('t.titre LIKE :mot')
            ->setParameter('mot',"%{$mot}%")
            ->getQuery()
            ->getResult();

            $topics = $this->paginatorInterface->paginate($data,$page,16);

            return $topics;            
        }


    }

    public function findPaginatedTopics($page): PaginationInterface
    {
        $data = $this->createQueryBuilder('t')
        ->addOrderBy('t.dateCreation', 'DESC')
        ->getQuery()
        ->getResult();

        $topics = $this->paginatorInterface->paginate($data,$page,16);

        return $topics;
    }

    public function findPaginatedTopicsNonSignales(int $page): PaginationInterface
    {

        // Nous devons trouver les topics dont l'id ne se trouve pas dans l'entité ReportTopic

        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        //Requête en deux temps

        $qb = $sub;
        $qb->select('to.id')
        ->from('App\Entity\ReportTopic', 'rt')
        ->join('rt.topic', 'to');
        
        $sub = $em->createQueryBuilder();
        /* Sélectionner tous les topics qui ne sont pas (NOT IN) le résultat précédent*/
        $sub->select('t')
        ->from('App\Entity\Topic', 't')
        ->where($sub->expr()->notIn('t.id', $qb->getDQL()))
        // Nous trions du plus ancien en premier au plus récent
        ->orderBy('t.dateCreation','ASC');

        $query = $sub->getQuery();
        $data = $query->getResult();
        $topics = $this->paginatorInterface->paginate($data,$page,20);

        return $topics;  

    }

    // public function findPaginatedVerrouilles($page): PaginationInterface
    // {
    //     $data = $this->createQueryBuilder('t')
    //     ->where('t.verrouillage = 1')
    //     ->addOrderBy('t.dateCreation', 'DESC')
    //     ->getQuery()
    //     ->getResult();

    //     $topicsVerrouilles = $this->paginatorInterface->paginate($data,$page,12);

    //     return $topicsVerrouilles;
    // }

    // public function findPaginatedDeverrouilles($page): PaginationInterface
    // {
    //     $data = $this->createQueryBuilder('t')
    //     ->where('t.verrouillage = 0')
    //     ->addOrderBy('t.dateCreation', 'DESC')
    //     ->getQuery()
    //     ->getResult();

    //     $topicsDeverrouilles = $this->paginatorInterface->paginate($data,$page,12);

    //     return $topicsDeverrouilles;
    // }

//    /**
//     * @return Topic[] Returns an array of Topic objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Topic
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
