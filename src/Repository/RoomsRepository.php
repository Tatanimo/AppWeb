<?php

namespace App\Repository;

use App\Entity\Rooms;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rooms>
 *
 * @method Rooms|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rooms|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rooms[]    findAll()
 * @method Rooms[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoomsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rooms::class);
    }

   /**
    * @return Rooms[] Returns an array of Rooms objects
    */
   public function findByReferenceId($id): array
   {
       return $this->createQueryBuilder('r')
           ->select('r, m')
           ->leftJoin('r.fk_messages', 'm')
           ->andWhere('r.reference LIKE :id')
           ->setParameter('id', "%$id%")
           ->orderBy('m.publication_date', 'DESC')
           ->getQuery()
           ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?Rooms
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
