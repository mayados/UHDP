<?php

namespace App\Repository;

use App\Entity\ReportMot;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<ReportMot>
 *
 * @method ReportMot|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportMot|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportMot[]    findAll()
 * @method ReportMot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportMotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, ReportMot::class);
    }

    public function save(ReportMot $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ReportMot $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findSignaleurMot($user, $mot){

        // Renvoie un array 

        $parameters = [
            'user' => $user,
            'mot' => $mot,
        ];

        return $this->createQueryBuilder('r')
        ->where('r.signaleur = :user')
        ->andWhere('r.mot = :mot')
        ->setParameters($parameters)
        ->getQuery()
        // ->getResult()
        ->getOneOrNullResult();

    }

    public function findPaginatedSignales(int $page): PaginationInterface
    {

        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        //Requête en deux temps

        $qb = $sub;
        $qb->select('mo.id')
        ->from('App\Entity\ReportMot', 'rm')
        ->join('rm.mot', 'mo');
        
        $sub = $em->createQueryBuilder();
        $sub->select('m')
        ->from('App\Entity\MotCommemoration', 'm')
        ->where($sub->expr()->In('m.id', $qb->getDQL()))
        ->addOrderBy('m.dateCreation', 'DESC');

        $query = $sub->getQuery();
        $data = $query->getResult();
        $mots = $this->paginatorInterface->paginate($data,$page,20);

        return $mots;  

    }

    public function findReportsByMot($idMot)
    {
        return $this->createQueryBuilder('r')
        ->where('r.mot = :idMot')
        ->setParameter('idMot',$idMot)
        ->getQuery()
        ->getResult();
    }

//    /**
//     * @return ReportMot[] Returns an array of ReportMot objects
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

//    public function findOneBySomeField($value): ?ReportMot
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
