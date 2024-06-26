<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, Post::class);
    }

    public function save(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findPaginatedPosts($page,$topic): PaginationInterface
    {
        $data = $this->createQueryBuilder('p')
        ->where('p.topic = :topic')
        ->setParameter('topic', $topic)
        ->addOrderBy('p.dateCreation', 'ASC')
        ->getQuery()
        ->getResult();

        $posts = $this->paginatorInterface->paginate($data,$page,3);

        return $posts;
    }

    public function findPaginatedPostsNonSignales(int $page): PaginationInterface
    {

        // Nous devons trouver les topics dont l'id ne se trouve pas dans l'entité ReportTopic

        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        //Requête en deux temps

        $qb = $sub;
        $qb->select('po.id')
        ->from('App\Entity\ReportPost', 'rp')
        ->join('rp.post', 'po');
        
        $sub = $em->createQueryBuilder();
        /* Sélectionner tous les topics qui ne sont pas (NOT IN) le résultat précédent*/
        $sub->select('p')
        ->from('App\Entity\Post', 'p')
        ->where($sub->expr()->notIn('p.id', $qb->getDQL()))
        // Nous trions du plus ancien en premier au plus récent
        ->orderBy('p.dateCreation','ASC');

        $query = $sub->getQuery();
        $data = $query->getResult();
        $posts = $this->paginatorInterface->paginate($data,$page,20);

        return $posts;  

    }

    public function findFirstPost($idTopic)
    {
        return $this->createQueryBuilder('p')
        ->select('p.texte','p.id')
        ->leftJoin('p.topic','t')
        ->where('t.id = :idTopic')
        ->setParameter('idTopic', $idTopic)
        ->addOrderBy('p.dateCreation', 'ASC')
        ->setMaxResults(1)
        ->getQuery()
        ->getResult();
    }

//    /**
//     * @return Post[] Returns an array of Post objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Post
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
