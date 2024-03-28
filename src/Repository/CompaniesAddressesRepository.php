<?php

namespace App\Repository;

use App\Entity\CompaniesAddresses;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompaniesAddresses>
 *
 * @method CompaniesAddresses|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompaniesAddresses|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompaniesAddresses[]    findAll()
 * @method CompaniesAddresses[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompaniesAddressesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompaniesAddresses::class);
    }

    //    /**
    //     * @return CompaniesAddresses[] Returns an array of CompaniesAddresses objects
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

    //    public function findOneBySomeField($value): ?CompaniesAddresses
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
