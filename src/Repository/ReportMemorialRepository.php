<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\AnimalMemorial;
use App\Entity\ReportMemorial;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<ReportMemorial>
 *
 * @method ReportMemorial|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportMemorial|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportMemorial[]    findAll()
 * @method ReportMemorial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportMemorialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, ReportMemorial::class);
    }

    public function save(ReportMemorial $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ReportMemorial $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findSignaleurMemorial($user, $memorial){

        // Renvoie un array 

        $parameters = [
            'user' => $user,
            'memorial' => $memorial,
        ];

        return $this->createQueryBuilder('r')
        ->where('r.signaleur = :user')
        ->andWhere('r.memorial = :memorial')
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
        $qb->select('me.id')
        ->from('App\Entity\ReportMemorial', 'rm')
        ->join('rm.memorial', 'me');
        
        $sub = $em->createQueryBuilder();
        $sub->select('m')
        ->from('App\Entity\AnimalMemorial', 'm')
        ->where($sub->expr()->In('m.id', $qb->getDQL()))
        ->addOrderBy('m.dateCreation', 'DESC');

        $query = $sub->getQuery();
        $data = $query->getResult();
        $memoriaux = $this->paginatorInterface->paginate($data,$page,20);

        return $memoriaux;  

    }

    public function findReportsByMemorial($idMemorial)
    {
        return $this->createQueryBuilder('r')
        ->where('r.memorial = :idMemorial')
        ->setParameter('idMemorial',$idMemorial)
        ->getQuery()
        ->getResult();
    }

//    /**
//     * @return ReportMemorial[] Returns an array of ReportMemorial objects
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

//    public function findOneBySomeField($value): ?ReportMemorial
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
