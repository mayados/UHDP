<?php

namespace App\Repository;

use App\Entity\ReportPost;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<ReportPost>
 *
 * @method ReportPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportPost[]    findAll()
 * @method ReportPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, ReportPost::class);
    }

    public function save(ReportPost $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ReportPost $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findSignaleurPost($user, $post){

        // Renvoie un array 

        $parameters = [
            'user' => $user,
            'post' => $post,
        ];

        return $this->createQueryBuilder('r')
        ->where('r.signaleur = :user')
        ->andWhere('r.post = :post')
        ->setParameters($parameters)
        ->getQuery()
        // ->getResult()
        ->getOneOrNullResult();

    }

    public function findPaginatedPostsSignales(int $page): PaginationInterface
    {

        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        //Requête en deux temps

        $qb = $sub;
        $qb->select('po.id')
        ->from('App\Entity\ReportPost', 'rp')
        ->join('rp.post', 'po');
        
        $sub = $em->createQueryBuilder();
        /* Sélectionner tous les topics qui ne sont pas (NOT IN) le résultat précédent*/
        // Cette deuxieme requete est effectuée afin de récupérer la totalité de l'entité Topic, notamment pour accéder à ses méthodes
        $sub->select('p')
        ->from('App\Entity\Post', 'p')
        ->where($sub->expr()->In('p.id', $qb->getDQL()))
        // Nous trions du plus ancien en premier au plus récent
        ->orderBy('p.dateCreation','ASC');

        $query = $sub->getQuery();
        $data = $query->getResult();
        $postsSignales = $this->paginatorInterface->paginate($data,$page,20);

        return $postsSignales;  

    }

    public function findReportsByPost($idPost)
    {
        return $this->createQueryBuilder('r')
        ->where('r.post = :idPost')
        ->setParameter('idPost',$idPost)
        ->getQuery()
        ->getResult();
    }

//    /**
//     * @return ReportPost[] Returns an array of ReportPost objects
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

//    public function findOneBySomeField($value): ?ReportPost
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
