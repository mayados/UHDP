<?php

namespace App\Repository;

use App\Entity\BelleHistoire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<BelleHistoire>
 *
 * @method BelleHistoire|null find($id, $lockMode = null, $lockVersion = null)
 * @method BelleHistoire|null findOneBy(array $criteria, array $orderBy = null)
 * @method BelleHistoire[]    findAll()
 * @method BelleHistoire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BelleHistoireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, BelleHistoire::class);
    }

    public function save(BelleHistoire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BelleHistoire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findLastHistoires()
    {
        return $this->createQueryBuilder('h')
        // ->select('h.slug','h.titre','h.photo','h.genre','h.dateCreation')
        ->where('h.etat LIKE :state')
        ->setParameter('state','%STATE_APPROUVED%')
        ->addOrderBy('h.datePublication', 'DESC')
        ->setMaxResults(4)
        ->getQuery()
        ->getResult();
    }

    public function findPaginatedHistoires($page): PaginationInterface
    {
        $data = $this->createQueryBuilder('h')
        ->where('h.etat LIKE :state')
        ->setParameter('state','%STATE_APPROUVED%')
        ->addOrderBy('h.datePublication', 'DESC')
        ->getQuery()
        ->getResult();

        $histoires = $this->paginatorInterface->paginate($data,$page,12);

        return $histoires;
    }

    public function findPaginatedHistoiresByGenre($page,$genreId): PaginationInterface
    {

        $parameters = [
            'genreId' => $genreId,
            'state' => '%STATE_APPROUVED%',
        ];

        $data = $this->createQueryBuilder('h')
        ->where('h.genre = :genreId')
        ->andWhere('h.etat LIKE :state')
        ->setParameters($parameters)
        ->addOrderBy('h.datePublication', 'DESC')
        ->getQuery()
        ->getResult();

        $histoires = $this->paginatorInterface->paginate($data,$page,12);

        return $histoires;
    }

    public function findPaginatedPubliees($page): PaginationInterface
    {
        $data = $this->createQueryBuilder('h')
        ->leftJoin('h.auteur','a')
        ->select('h.titre','h.slug','h.dateCreation','a.id','a.pseudo')
        ->where('h.etat LIKE :state')
        ->setParameter('state','%STATE_APPROUVED%')
        ->addOrderBy('h.datePublication', 'DESC')
        ->getQuery()
        ->getResult();

        $histoires = $this->paginatorInterface->paginate($data,$page,12);

        return $histoires;
    }

    public function findPaginatedPublieesNonSignalees($page): PaginationInterface
    {
        // $data = $this->createQueryBuilder('h')
        // ->leftJoin('h.auteur','a')
        // ->select('h.titre','h.slug','h.dateCreation','a.id','a.pseudo')
        // ->where('h.etat LIKE :state')
        // ->setParameter('state','%STATE_APPROUVED%')
        // ->addOrderBy('h.dateCreation', 'DESC')
        // ->getQuery()
        // ->getResult();

        // $histoires = $this->paginatorInterface->paginate($data,$page,12);

        // return $histoires;

        // Nous devons trouver les topics dont l'id ne se trouve pas dans l'entité ReportTopic

        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        //Requête en deux temps

        $qb = $sub;
        $qb->select('hi.id')
        ->from('App\Entity\ReportHistoire', 'rh')
        ->join('rh.histoire', 'hi');
        
        $sub = $em->createQueryBuilder();
        /* Sélectionner tous les topics qui ne sont pas (NOT IN) le résultat précédent*/
        $sub->select('h')
        ->from('App\Entity\BelleHistoire', 'h')
        ->where($sub->expr()->notIn('h.id', $qb->getDQL()))
        ->andWhere('h.etat LIKE :state')
        ->setParameter('state','%STATE_APPROUVED%')
        ->addOrderBy('h.datePublication', 'DESC')
        ->getQuery()
        ->getResult();


        $query = $sub->getQuery();
        $data = $query->getResult();
        $histoiresPubliees = $this->paginatorInterface->paginate($data,$page,20);

        return $histoiresPubliees;  

    }

    public function findPaginatedWaiting($page): PaginationInterface
    {
        $data = $this->createQueryBuilder('h')
        ->leftJoin('h.auteur','a')
        ->select('h.titre','h.slug','h.dateCreation','a.id','a.pseudo')
        ->where('h.etat LIKE :state')
        ->setParameter('state','%STATE_WAITING%')
        ->addOrderBy('h.dateCreation', 'DESC')
        ->getQuery()
        ->getResult();

        $histoires = $this->paginatorInterface->paginate($data,$page,12);

        return $histoires;
    }

    public function findPaginatedDisapprouved($page): PaginationInterface
    {
        $data = $this->createQueryBuilder('h')
        ->leftJoin('h.auteur','a')
        ->select('h.titre','h.slug','h.dateCreation','a.id','a.pseudo')
        ->where('h.etat LIKE :state')
        ->setParameter('state','%STATE_DISAPPROUVED%')
        ->addOrderBy('h.dateCreation', 'DESC')
        ->getQuery()
        ->getResult();

        $histoires = $this->paginatorInterface->paginate($data,$page,12);

        return $histoires;
    }

    public function findMyWaitings($user)
    {

        $parameters = [
            'user' => $user,
            'state' => "%STATE_WAITING%"
        ];

        return $this->createQueryBuilder('h')
        ->select('h.id','h.slug','h.titre')
        ->where('h.etat LIKE :state')
        ->andWhere('h.auteur = :user')
        ->setParameters($parameters)
        ->orderBy('h.dateCreation', 'DESC')
        ->getQuery()
        ->getResult();
    }

    public function findMyDrafts($user)
    {

        $parameters = [
            'user' => $user,
            'state' => "%STATE_DRAFT%",
        ];

        return $this->createQueryBuilder('h')
        ->select(['h.id','h.slug','h.titre'])
        ->where('h.etat LIKE :state')
        ->andWhere('h.auteur = :user')
        ->setParameters($parameters)
        ->addOrderBy('h.dateCreation', 'DESC')
        ->getQuery()
        ->getResult();
    }

    public function findMyApprouved($user)
    {

        $parameters = [
            'user' => $user,
            'state' => "%STATE_APPROUVED%",
        ];

        return $this->createQueryBuilder('h')
        ->where('h.etat LIKE :state')
        ->andWhere('h.auteur = :user')
        ->setParameters($parameters)
        ->addOrderBy('h.datePublication', 'DESC')
        ->getQuery()
        ->getResult();
    }

    public function findMyDisapprouved($user)
    {

        $parameters = [
            'user' => $user,
            'state' => "%STATE_DISAPPROUVED%",
        ];

        return $this->createQueryBuilder('h')
        ->select(['h.id','h.slug','h.titre'])
        ->where('h.etat LIKE :state')
        ->andWhere('h.auteur = :user')
        ->setParameters($parameters)
        ->addOrderBy('h.dateCreation', 'DESC')
        ->getQuery()
        ->getResult();
    }

    public function findAutresHistoires($id)
    {
        // On crée une fonction ici car la logique ne doit pas se retouver majoritairement dans le controller, il est avant tout fait pour rediriger sur les vues
        return $this->createQueryBuilder('h')
        ->where('h.id != :id')
        ->setParameter('id',$id)
        ->orderBy('RAND()')
        ->setMaxResults(3)
        ->getQuery()
        ->getResult();

    }

}
