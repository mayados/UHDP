<?php

namespace App\Repository;

use App\Entity\ReportHistoire;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<ReportHistoire>
 *
 * @method ReportHistoire|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportHistoire|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportHistoire[]    findAll()
 * @method ReportHistoire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportHistoireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, ReportHistoire::class);
    }

    public function save(ReportHistoire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ReportHistoire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findSignaleurHistoire($user, $histoire){

        // Renvoie un array 

        $parameters = [
            'user' => $user,
            'histoire' => $histoire,
        ];

        return $this->createQueryBuilder('r')
        ->where('r.signaleur = :user')
        ->andWhere('r.histoire = :histoire')
        ->setParameters($parameters)
        ->getQuery()
        // ->getResult()
        ->getOneOrNullResult();

    }

    public function findPaginatedPublieesSignalees(int $page): PaginationInterface
    {

        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        //Requête en deux temps

        $qb = $sub;
        $qb->select('hi.id')
        ->from('App\Entity\ReportHistoire', 'rh')
        ->join('rh.histoire', 'hi');
        
        $sub = $em->createQueryBuilder();
        /* Sélectionner tous les topics qui ne sont pas (NOT IN) le résultat précédent*/
        // Cette deuxieme requete est effectuée afin de récupérer la totalité de l'entité Topic, notamment pour accéder à ses méthodes
        $sub->select('h')
        ->from('App\Entity\BelleHistoire', 'h')
        ->where($sub->expr()->In('h.id', $qb->getDQL()))
        ->andWhere('h.etat LIKE :state')
        ->setParameter('state','%STATE_APPROUVED%')
        ->addOrderBy('h.dateCreation', 'DESC');

        $query = $sub->getQuery();
        $data = $query->getResult();
        $histoiresSignalees = $this->paginatorInterface->paginate($data,$page,20);

        return $histoiresSignalees;  

    }

//    /**
//     * @return ReportHistoire[] Returns an array of ReportHistoire objects
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

//    public function findOneBySomeField($value): ?ReportHistoire
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
