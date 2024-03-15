<?php

namespace App\Repository;

use App\Entity\FamilyAnimals;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FamilyAnimals>
 *
 * @method FamilyAnimals|null find($id, $lockMode = null, $lockVersion = null)
 * @method FamilyAnimals|null findOneBy(array $criteria, array $orderBy = null)
 * @method FamilyAnimals[]    findAll()
 * @method FamilyAnimals[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FamilyAnimalsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FamilyAnimals::class);
    }

    //    /**
    //     * @return FamilyAnimals[] Returns an array of FamilyAnimals objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?FamilyAnimals
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
