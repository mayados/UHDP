<?php

namespace App\Repository;

use App\Entity\Refuge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Refuge>
 *
 * @method Refuge|null find($id, $lockMode = null, $lockVersion = null)
 * @method Refuge|null findOneBy(array $criteria, array $orderBy = null)
 * @method Refuge[]    findAll()
 * @method Refuge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RefugeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, Refuge::class);
    }

    public function save(Refuge $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Refuge $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findPaginatedRefugesForAdmin($page): PaginationInterface
    {
        $data = $this->createQueryBuilder('r')
        ->select('r.id','r.nom','r.numero','r.rue','r.ville','r.codePostal','r.departement')
        ->getQuery()
        ->getResult();

        $refuges = $this->paginatorInterface->paginate($data,$page,16);

        return $refuges;
    }

//    /**
//     * @return Refuge[] Returns an array of Refuge objects
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

//    public function findOneBySomeField($value): ?Refuge
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
