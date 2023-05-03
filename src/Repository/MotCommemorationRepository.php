<?php

namespace App\Repository;

use App\Entity\MotCommemoration;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<MotCommemoration>
 *
 * @method MotCommemoration|null find($id, $lockMode = null, $lockVersion = null)
 * @method MotCommemoration|null findOneBy(array $criteria, array $orderBy = null)
 * @method MotCommemoration[]    findAll()
 * @method MotCommemoration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotCommemorationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, MotCommemoration::class);
    }

    public function save(MotCommemoration $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MotCommemoration $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findPaginatedNonSignales($page): PaginationInterface
    {

        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        //Requête en deux temps

        $qb = $sub;
        $qb->select('mo.id')
        ->from('App\Entity\ReportMot', 'rm')
        ->join('rm.mot', 'mo');
        
        $sub = $em->createQueryBuilder();
        /* Sélectionner tous les mots qui ne sont pas (NOT IN) le résultat précédent*/
        $sub->select('m')
        ->from('App\Entity\MotCommemoration', 'm')
        ->where($sub->expr()->notIn('m.id', $qb->getDQL()))
        ->addOrderBy('m.dateCreation', 'DESC')
        ->getQuery()
        ->getResult();


        $query = $sub->getQuery();
        $data = $query->getResult();
        $mots = $this->paginatorInterface->paginate($data,$page,20);

        return $mots;  

    }

//    /**
//     * @return MotCommemoration[] Returns an array of MotCommemoration objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MotCommemoration
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
