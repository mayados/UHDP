<?php

namespace App\Repository;

use App\Entity\ReportCondoleance;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
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

    public function findSignaleurCondoleance($user, $condoleance){

        // Renvoie un array 

        $parameters = [
            'user' => $user,
            'condoleance' => $condoleance,
        ];

        return $this->createQueryBuilder('r')
        ->where('r.signaleur = :user')
        ->andWhere('r.condoleance = :condoleance')
        ->setParameters($parameters)
        ->getQuery()
        // ->getResult()
        ->getOneOrNullResult();

    }

    public function findPaginatedSignalees(int $page): PaginationInterface
    {

        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        //Requête en deux temps

        $qb = $sub;
        $qb->select('co.id')
        ->from('App\Entity\ReportCondoleance', 'rc')
        ->join('rc.condoleance', 'co');
        
        $sub = $em->createQueryBuilder();
        $sub->select('c')
        ->from('App\Entity\Condoleance', 'c')
        ->where($sub->expr()->In('c.id', $qb->getDQL()))
        ->addOrderBy('c.dateCreation', 'DESC');

        $query = $sub->getQuery();
        $data = $query->getResult();
        $condoleances = $this->paginatorInterface->paginate($data,$page,20);

        return $condoleances;  

    }

    public function findReportsByCondoleance($idCondoleance)
    {
        return $this->createQueryBuilder('r')
        ->where('r.condoleance = :idCondoleance')
        ->setParameter('idCondoleance',$idCondoleance)
        ->getQuery()
        ->getResult();
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
