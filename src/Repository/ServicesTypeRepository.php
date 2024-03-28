<?php

namespace App\Repository;

use App\Entity\ServicesType;
use App\Entity\TypeCompany;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ServicesType>
 *
 * @method ServicesType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServicesType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServicesType[]    findAll()
 * @method ServicesType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServicesTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServicesType::class);
    }

//    /**
//     * @return TypeCompany[] Returns an array of TypeCompany objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TypeCompany
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
