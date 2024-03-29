<?php

namespace App\Repository;

use App\Entity\Reactions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reactions>
 *
 * @method Reactions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reactions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reactions[]    findAll()
 * @method Reactions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReactionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reactions::class);
    }

    //    /**
    //     * @return Reactions[] Returns an array of Reactions objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

       public function findOneByUserAndPost($user, $post): ?Reactions
       {
           return $this->createQueryBuilder('r')
               ->andWhere('r.users = :user')
               ->andWhere('r.posts = :post')
               ->setParameters(
                    new ArrayCollection([
                        new Parameter('user', $user),
                        new Parameter('post', $post)
                    ])
               )
               ->getQuery()
               ->getOneOrNullResult()
           ;
       }

       public function findOneByUserAndCommentary($user, $commentary): ?Reactions
       {
           return $this->createQueryBuilder('r')
               ->andWhere('r.users = :user')
               ->andWhere('r.commentaries = :commentary')
               ->setParameters(
                    new ArrayCollection([
                        new Parameter('user', $user),
                        new Parameter('commentary', $commentary)
                    ])
               )
               ->getQuery()
               ->getOneOrNullResult()
           ;
       }
}
