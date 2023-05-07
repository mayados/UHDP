<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface )
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }

    // Trouver que les roles user pas les admin
    public function findBannedUsersNotAdmin(int $page): PaginationInterface
    {
        $data = $this->createQueryBuilder('u')
            ->where("JSON_EXTRACT(u.roles, '$[0]') = 'ROLE_USER'")
            ->andWhere('u.bannir = 1')
            ->getQuery()
            ->getResult();
        
        $utilisateursBannis = $this->paginatorInterface->paginate($data,$page,20);

        return $utilisateursBannis;
    }

    public function findNotBannedUsersNotAdmin(int $page): PaginationInterface
    {
        $data =  $this->createQueryBuilder('u')
            ->where("JSON_EXTRACT(u.roles, '$[0]') = 'ROLE_USER'")
            ->andWhere('u.bannir = 0')
            ->getQuery()
            ->getResult()
        ;

        $utilisateursNonBannis = $this->paginatorInterface->paginate($data,$page,20);

        return $utilisateursNonBannis;
    }

    public function findModerateurs(int $page): PaginationInterface
    {
        $data = $this->createQueryBuilder('u')
            ->where("JSON_EXTRACT(u.roles, '$[0]') = 'ROLE_MODERATEUR_HISTOIRES'")
            ->orWhere("JSON_EXTRACT(u.roles, '$[0]') = 'ROLE_MODERATEUR_FORUM'")
            ->orWhere("JSON_EXTRACT(u.roles, '$[0]') = 'ROLE_MODERATEUR_MEMORIAUX'")
            ->orWhere("JSON_EXTRACT(u.roles, '$[0]') = 'ROLE_MODERATEUR_COMMEMORATION'")
            ->getQuery()
            ->getResult();
        
        $moderateurs = $this->paginatorInterface->paginate($data,$page,20);

        return $moderateurs;
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
