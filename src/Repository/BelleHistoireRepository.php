<?php

namespace App\Repository;

use App\Entity\BelleHistoire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<BelleHistoire>
 *
 * @method BelleHistoire|null find($id, $lockMode = null, $lockVersion = null)
 * @method BelleHistoire|null findOneBy(array $criteria, array $orderBy = null)
 * @method BelleHistoire[]    findAll()
 * @method BelleHistoire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BelleHistoireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, BelleHistoire::class);
    }

    public function save(BelleHistoire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BelleHistoire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findPaginatedHistoires($page): PaginationInterface
    {
        $data = $this->createQueryBuilder('h')
        ->addOrderBy('h.dateCreation', 'DESC')
        ->getQuery()
        ->getResult();

        $histoires = $this->paginatorInterface->paginate($data,$page,3);

        return $histoires;
    }

//    /**
//     * @return BelleHistoire[] Returns an array of BelleHistoire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BelleHistoire
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
