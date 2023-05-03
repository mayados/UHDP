<?php

namespace App\Repository;

use App\Entity\CommentBelleHistoire;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
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

    
    public function findPaginatedNonSignales($page): PaginationInterface
    {

        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        //Requête en deux temps

        $qb = $sub;
        $qb->select('co.id')
        ->from('App\Entity\ReportComment', 'rc')
        ->join('rc.commentaire', 'co');
        
        $sub = $em->createQueryBuilder();
        /* Sélectionner tous les topics qui ne sont pas (NOT IN) le résultat précédent*/
        $sub->select('c')
        ->from('App\Entity\CommentBelleHistoire', 'c')
        ->where($sub->expr()->notIn('c.id', $qb->getDQL()))
        ->addOrderBy('c.dateCreation', 'DESC')
        ->getQuery()
        ->getResult();


        $query = $sub->getQuery();
        $data = $query->getResult();
        $commentaires = $this->paginatorInterface->paginate($data,$page,20);

        return $commentaires;  

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
