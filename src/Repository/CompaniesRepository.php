<?php

namespace App\Repository;

use App\Entity\Companies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Companies>
 *
 * @method Companies|null find($id, $lockMode = null, $lockVersion = null)
 * @method Companies|null findOneBy(array $criteria, array $orderBy = null)
 * @method Companies[]    findAll()
 * @method Companies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompaniesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Companies::class);
    }

//    /**
//     * @return Company[] Returns an array of Company objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Company
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
