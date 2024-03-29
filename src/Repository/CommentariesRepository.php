<?php

namespace App\Repository;

use App\Entity\Commentaries;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commentaries>
 *
 * @method Commentaries|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentaries|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentaries[]    findAll()
 * @method Commentaries[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentariesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaries::class);
    }

   /**
    * @return Commentaries[] Returns an array of Commentaries objects
    */
   public function findLimit50(): array
   {
       return $this->createQueryBuilder('c')
           ->setMaxResults(50)
           ->getQuery()
           ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?Commentaries
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
