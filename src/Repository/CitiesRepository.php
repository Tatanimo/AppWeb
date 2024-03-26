<?php

namespace App\Repository;

use App\Entity\Cities;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cities>
 *
 * @method Cities|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cities|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cities[]    findAll()
 * @method Cities[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CitiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cities::class);
    }

       /**
        * @return Cities[] Returns an array of Cities objects
        */
       public function findByName($value): array
       {
           return $this->createQueryBuilder('c')
               ->andWhere('UPPER(c.name) LIKE UPPER(:val)')
               ->setParameter('val', $value.'%')
               ->orderBy('c.name', 'DESC')
               ->setMaxResults(10)
               ->getQuery()
               ->getResult()
           ;
       }

        /**
        * @return Cities[] Returns an array of Cities objects
        */
        public function findByNameAndZipCode($name, $zipCode): array
        {
            return $this->createQueryBuilder('c')
                ->andWhere('UPPER(c.name) LIKE UPPER(:name)')
                ->andWhere('c.zip_code LIKE :zipcode')
                ->setParameters(
                    new ArrayCollection([
                        new Parameter('name', $name.'%'),
                        new Parameter('zipcode', $zipCode.'%')
                    ])
                )
                ->orderBy('c.name', 'DESC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult()
            ;
        }

        
        public function findOneByRequest($request) : Cities
        {
            $explodeCity = explode('(', $request);
            $cityName = trim($explodeCity[0]);
            $zipCode = rtrim($explodeCity[1], ')');
            return $this->findOneBy(['name' => $cityName, 'zip_code' => $zipCode]);
        }   

    //    public function findOneBySomeField($value): ?Cities
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
