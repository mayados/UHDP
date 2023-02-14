<?php

namespace App\Repository;

use App\Entity\CommentBelleHistoire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CommentBelleHistoire>
 *
 * @method CommentBelleHistoire|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentBelleHistoire|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentBelleHistoire[]    findAll()
 * @method CommentBelleHistoire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentBelleHistoireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentBelleHistoire::class);
    }

    public function save(CommentBelleHistoire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CommentBelleHistoire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CommentBelleHistoire[] Returns an array of CommentBelleHistoire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CommentBelleHistoire
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
