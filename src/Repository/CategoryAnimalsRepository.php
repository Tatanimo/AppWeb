<?php

namespace App\Repository;

use App\Entity\CategoryAnimals;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryAnimals>
 *
 * @method CategoryAnimals|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryAnimals|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryAnimals[]    findAll()
 * @method CategoryAnimals[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryAnimalsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryAnimals::class);
    }

    public function randomCategory(){
        $allCategories = $this->findAll();
        $randomIndex = rand(0, count($allCategories) - 1);
        return $allCategories[$randomIndex];
    }

//    /**
//     * @return CategoryAnimals[] Returns an array of CategoryAnimals objects
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

//    public function findOneBySomeField($value): ?CategoryAnimals
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
