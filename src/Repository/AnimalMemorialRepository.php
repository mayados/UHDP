<?php

namespace App\Repository;

use App\Data\SearchData;
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
        ->select('m.id','m.nom','m.dateCreation','m.photo')
        ->addOrderBy('m.dateCreation', 'DESC')
        ->getQuery()
        ->getResult();

        $memoriaux = $this->paginatorInterface->paginate($data,$page,16);

        return $memoriaux;
    }

    public function findMemoriauxOfMonth($now)
    {
        // On crée une fonction ici car la logique ne doit pas se retouver majoritairement dans le controller, il est avant tout fait pour rediriger sur les vues
        return $this->createQueryBuilder('m')
        ->select('m.id','m.nom','m.dateCreation','m.photo','m.dateDeces')
        ->where('MONTH(m.dateDeces) = MONTH(:now)')
        ->setParameter('now',$now)
        ->orderBy('RAND()')
        ->setMaxResults(5)
        ->getQuery()
        ->getResult();

    }

    public function findPaginatedMemoriauxNonSignales(int $page): PaginationInterface
    {

        // Nous devons trouver les mémoriaux dont l'id ne se trouve pas dans l'entité ReportMmeorial

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
        ->where($sub->expr()->notIn('m.id', $qb->getDQL()))
        // Nous trions du plus récent en premier au plus ancien
        ->orderBy('m.dateCreation','DESC');

        $query = $sub->getQuery();
        $data = $query->getResult();
        $memoriaux = $this->paginatorInterface->paginate($data,$page,20);

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

        $memoriaux = $this->paginatorInterface->paginate($data,$page,16);

        return $memoriaux;
    }

    // On doit retourner Pagination interface car les résultats de la recherche doivent être paginés
    public function findBySearch(SearchData $searchData,int $page): PaginationInterface
    {
        $data = $this->createQueryBuilder('m')
        ->select('c','m')
        // On joint l'entité Categorie qui est dans la colonne categorieAnimal et on lui donne l'alias c
        ->join('m.categorieAnimal', 'c')
        ->addOrderBy('m.dateCreation', 'DESC');

        if(!empty($searchData->q)){
            $data = $data
            ->andWhere('m.nom LIKE :q')
            ->setParameter('q',"%{$searchData->q}%");
        }

        if(!empty($searchData->categories)){
            $data = $data 
            // On veut les résultats où l'id de la catégorie du mémorial et dans la liste des catégories de la recherche
            ->andWhere('c.id IN (:categories)')
            ->setParameter('categories', $searchData->categories);
        }

        if(!empty($searchData->sexe)){
            $data = $data
            ->andWhere('m.sexe IN (:sexe)')
            ->setParameter('sexe', $searchData->sexe);
        }

        if(!empty($searchData->anneeDeces)){
            $data = $data
            // ->andWhere('DAY(m.dateDeces) = DAY(:deces)')
            // ->andWhere('MONTH(m.dateDeces) = MONTH(:deces)')
            ->andWhere('YEAR(m.dateDeces) = :deces')
            ->setParameter('deces', $searchData->anneeDeces);
        }

        if(!empty($searchData->moisDeces)){
            $data = $data
            // ->andWhere('DAY(m.dateDeces) = DAY(:deces)')
            // ->andWhere('MONTH(m.dateDeces) = MONTH(:deces)')
            ->andWhere('MONTH(m.dateDeces) = :moisDeces')
            ->setParameter('moisDeces', $searchData->moisDeces);
        }

        if(!empty($searchData->jourDeces)){
            $data = $data
            // ->andWhere('DAY(m.dateDeces) = DAY(:deces)')
            // ->andWhere('MONTH(m.dateDeces) = MONTH(:deces)')
            ->andWhere('DAY(m.dateDeces) = :jourDeces')
            ->setParameter('jourDeces', $searchData->jourDeces);
        }

        $data = $data
        ->getQuery()
        ->getResult();

        $memoriaux = $this->paginatorInterface->paginate($data,$page,16);
        return $memoriaux;
    }

    // On veut obtenir le résultat par catégorie, car nous sommes dans une catégorie précise
    public function findSearchByCategorie(SearchData $searchData, $categorie, int $page): PaginationInterface
    {

        // On a déja la catégorie, donc on veut trouver un memorial où m.categorie = $categorie
        $data = $this->createQueryBuilder('m')
        ->select('c','m')
        // On joint l'entité Categorie qui est dans la colonne categorieAnimal et on lui donne l'alias c
        ->join('m.categorieAnimal', 'c')
        ->addOrderBy('m.dateCreation', 'DESC')
        ->setParameter('categorie', $categorie);

        if(!empty($searchData->q)){
            $data = $data
            ->andWhere('m.nom LIKE :q')
            ->andWhere('c.id = :categorie')
            ->setParameter('q', "%{$searchData->q}%" );
        }

        if(!empty($searchData->sexe)){
            $data = $data
            ->andWhere('m.sexe IN (:sexe)')
            ->andWhere('c.id = :categorie')
            ->setParameter('sexe', $searchData->sexe);
        }else{
            $data = $data 
            ->andWhere('c.id = :categorie');
        }

        if(!empty($searchData->anneeDeces)){
            $data = $data
            ->andWhere('YEAR(m.dateDeces) = :deces')
            ->andWhere('c.id = :categorie')
            ->setParameter('deces', $searchData->anneeDeces);
        }

        if(!empty($searchData->moisDeces)){
            $data = $data
            ->andWhere('MONTH(m.dateDeces) = :moisDeces')
            ->andWhere('c.id = :categorie')
            ->setParameter('moisDeces', $searchData->moisDeces);
        }

        $data = $data
        ->getQuery()
        ->getResult();

        $memoriaux = $this->paginatorInterface->paginate($data,$page,16);
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
