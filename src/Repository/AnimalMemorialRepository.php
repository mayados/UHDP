<?php

namespace App\Repository;

use App\Entity\AnimalMemorial;
use App\Entity\CategorieAnimal;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<AnimalMemorial>
 *
 * @method AnimalMemorial|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnimalMemorial|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnimalMemorial[]    findAll()
 * @method AnimalMemorial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalMemorialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface )
    {
        parent::__construct($registry, AnimalMemorial::class);

    }

    public function save(AnimalMemorial $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AnimalMemorial $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findPaginatedMemoriaux(int $page): PaginationInterface
    {
        // On crée une fonction ici car la logique ne doit pas se retouver majoritairement dans le controller, il est avant tout fait pour rediriger sur les vues
        $data = $this->createQueryBuilder('m')
        ->addOrderBy('m.dateCreation', 'DESC')
        ->getQuery()
        ->getResult();

        $memoriaux = $this->paginatorInterface->paginate($data,$page,3);

        return $memoriaux;
    }

    public function findPaginatedMemoriauxByCategorie(int $page,$categorie): PaginationInterface
    {
        // On crée une fonction ici car la logique ne doit pas se retouver majoritairement dans le controller, il est avant tout fait pour rediriger sur les vues
        $data = $this->createQueryBuilder('m')
        ->where('m.categorieAnimal = :categorie')
        ->setParameter('categorie', $categorie)
        ->addOrderBy('m.dateCreation', 'DESC')
        ->getQuery()
        ->getResult();

        $memoriaux = $this->paginatorInterface->paginate($data,$page,3);

        return $memoriaux;
    }

//    /**
//     * @return AnimalMemorial[] Returns an array of AnimalMemorial objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AnimalMemorial
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
