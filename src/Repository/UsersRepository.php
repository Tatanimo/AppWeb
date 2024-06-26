<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<Users>
 * @implements PasswordUpgraderInterface<Users>
 *
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Users) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
    * @return Users[] Returns an array of User objects
    */
   public function findSinceOneMonth(): array
   {
        $now = new \DateTime('now');
        $since = new \Datetime('last month');

       return $this->createQueryBuilder('u')
           ->andWhere('u.created_date <= :now')
           ->andWhere('u.created_date >= :since')
           ->setParameter('now', $now)
           ->setParameter('since', $since)
           ->orderBy('u.id', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }

   /**
    * @return Users[] Returns an array of User objects
    */
   public function findAllByRole($role): array
   {
       return $this->createQueryBuilder('u')
           ->andWhere('u.roles LIKE :role')
           ->setParameter('role', '%'.$role.'%')
           ->orderBy('u.id', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }

   public function findOneByRole($role): ?Users
   {
       return $this->createQueryBuilder('u')
           ->andWhere('u.roles LIKE :role')
           ->setParameter('role', '%'.$role.'%')
           ->getQuery()
           ->getOneOrNullResult()
       ;
   }

    public function randomUser(){
        $allUsers = $this->findAll();
        $randomIndex = rand(0, count($allUsers) - 1);
        return $allUsers[$randomIndex];
    }

    public function findOneByEmail($email): ?Users
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
