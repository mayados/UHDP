<?php

namespace App\Repository;

use App\Entity\ReportCondoleance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReportCondoleance>
 *
 * @method ReportCondoleance|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportCondoleance|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportCondoleance[]    findAll()
 * @method ReportCondoleance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportCondoleanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReportCondoleance::class);
    }

    public function save(ReportCondoleance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ReportCondoleance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ReportCondoleance[] Returns an array of ReportCondoleance objects
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

//    public function findOneBySomeField($value): ?ReportCondoleance
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
