<?php

namespace App\Repository;

use App\Entity\Reviews;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reviews>
 *
 * @method Reviews|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reviews|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reviews[]    findAll()
 * @method Reviews[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reviews::class);
    }

//    /**
//     * @return AvisUser[] Returns an array of AvisUser objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

        public function findOneByUserAndProfessional($user, $professional, $isProfessionalReceiver): ?Reviews
        {
            return $this->createQueryBuilder('a')
                ->andWhere('a.user = :user')
                ->andWhere('a.professional = :professional')
                ->andWhere('a.professional_receiver = :isProfessionalReceiver')
                ->setParameters(
                    new ArrayCollection([
                        new Parameter('user', $user),
                        new Parameter('professional', $professional),
                        new Parameter('isProfessionalReceiver', $isProfessionalReceiver),
                    ])
                )
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }
}
