<?php

namespace App\Repository;

use App\Entity\Professionals;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Professionals>
 *
 * @method Professionals|null find($id, $lockMode = null, $lockVersion = null)
 * @method Professionals|null findOneBy(array $criteria, array $orderBy = null)
 * @method Professionals[]    findAll()
 * @method Professionals[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfessionalsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Professionals::class);
    }

    public function randomProfessional(){
        $allProfessionals = $this->findAll();
        $randomIndex = rand(0, count($allProfessionals) - 1);
        return $allProfessionals[$randomIndex];
    }

//    /**
//     * @return Professionals[] Returns an array of Professionals objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Professionals
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
