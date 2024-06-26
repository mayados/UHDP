<?php

namespace App\Repository;

use App\Entity\Condoleance;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Condoleance>
 *
 * @method Condoleance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Condoleance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Condoleance[]    findAll()
 * @method Condoleance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CondoleanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, Condoleance::class);
    }

    public function save(Condoleance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Condoleance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findPaginatedCondoleancesNonSignalees(int $page): PaginationInterface
    {
        // On crée une fonction ici car la logique ne doit pas se retouver majoritairement dans le controller, il est avant tout fait pour rediriger sur les vues
        // $data = $this->createQueryBuilder('c')
        // ->leftJoin('c.auteur','a')
        // ->leftJoin('c.memorial','m')
        // ->select('c.dateCreation','c.texte','a.id','a.pseudo','m.nom')
        // ->addOrderBy('c.dateCreation', 'DESC')
        // ->getQuery()
        // ->getResult();

        // $condoleances = $this->paginatorInterface->paginate($data,$page,20);

        // return $condoleances;

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
        ->where($sub->expr()->notIn('c.id', $qb->getDQL()))
        // Nous trions du plus récent en premier au plus ancien
        ->orderBy('c.dateCreation','DESC');

        $query = $sub->getQuery();
        $data = $query->getResult();
        $condoleances = $this->paginatorInterface->paginate($data,$page,20);

        return $condoleances;  
    }

    public function findPaginatedCondoleances($memorial,$page): PaginationInterface
    {
        $data = $this->createQueryBuilder('c')
        ->where('c.memorial = :memorial')
        ->setParameter('memorial',$memorial)
        ->addOrderBy('c.dateCreation', 'DESC')
        ->getQuery()
        ->getResult();

        $condoleances = $this->paginatorInterface->paginate($data,$page,6);

        return $condoleances;
    }

//    /**
//     * @return Condoleance[] Returns an array of Condoleance objects
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

//    public function findOneBySomeField($value): ?Condoleance
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
