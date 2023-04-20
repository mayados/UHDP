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

    public function findPaginatedTopics($page): PaginationInterface
    {
        $data = $this->createQueryBuilder('t')
        ->addOrderBy('t.dateCreation', 'DESC')
        ->getQuery()
        ->getResult();

        $topics = $this->paginatorInterface->paginate($data,$page,3);

        return $topics;
    }

    public function findPaginatedVerrouilles($page): PaginationInterface
    {
        $data = $this->createQueryBuilder('t')
        ->where('t.verrouillage = 1')
        ->addOrderBy('t.dateCreation', 'DESC')
        ->getQuery()
        ->getResult();

        $topicsVerrouilles = $this->paginatorInterface->paginate($data,$page,12);

        return $topicsVerrouilles;
    }

    public function findPaginatedDeverrouilles($page): PaginationInterface
    {
        $data = $this->createQueryBuilder('t')
        ->where('t.verrouillage = 0')
        ->addOrderBy('t.dateCreation', 'DESC')
        ->getQuery()
        ->getResult();

        $topicsDeverrouilles = $this->paginatorInterface->paginate($data,$page,12);

        return $topicsDeverrouilles;
    }

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
