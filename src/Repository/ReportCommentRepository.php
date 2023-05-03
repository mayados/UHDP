<?php

namespace App\Repository;

use App\Entity\ReportComment;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<ReportComment>
 *
 * @method ReportComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportComment[]    findAll()
 * @method ReportComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, ReportComment::class);
    }

    public function save(ReportComment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ReportComment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findSignaleurComment($user, $comment){

        // Renvoie un array 

        $parameters = [
            'user' => $user,
            'comment' => $comment,
        ];

        return $this->createQueryBuilder('r')
        ->where('r.signaleur = :user')
        ->andWhere('r.commentaire = :comment')
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
        $qb->select('co.id')
        ->from('App\Entity\ReportComment', 'rc')
        ->join('rc.commentaire', 'co');
        
        $sub = $em->createQueryBuilder();
        /* Sélectionner tous les topics qui ne sont pas (NOT IN) le résultat précédent*/
        // Cette deuxieme requete est effectuée afin de récupérer la totalité de l'entité Topic, notamment pour accéder à ses méthodes
        $sub->select('c')
        ->from('App\Entity\CommentBelleHistoire', 'c')
        ->where($sub->expr()->In('c.id', $qb->getDQL()))
        // Nous trions du plus ancien en premier au plus récent
        ->orderBy('c.dateCreation','ASC');

        $query = $sub->getQuery();
        $data = $query->getResult();
        $commentaires = $this->paginatorInterface->paginate($data,$page,20);

        return $commentaires;  

    }

//    /**
//     * @return ReportComment[] Returns an array of ReportComment objects
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

//    public function findOneBySomeField($value): ?ReportComment
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
