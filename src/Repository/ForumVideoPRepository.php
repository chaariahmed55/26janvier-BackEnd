<?php

namespace App\Repository;

use App\Entity\ForumVideoP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ForumVideoP|null find($id, $lockMode = null, $lockVersion = null)
 * @method ForumVideoP|null findOneBy(array $criteria, array $orderBy = null)
 * @method ForumVideoP[]    findAll()
 * @method ForumVideoP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForumVideoPRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ForumVideoP::class);
    }

    // /**
    //  * @return ForumVideoP[] Returns an array of ForumVideoP objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ForumVideoP
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
