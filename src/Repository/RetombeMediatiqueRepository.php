<?php

namespace App\Repository;

use App\Entity\RetombeMediatique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RetombeMediatique|null find($id, $lockMode = null, $lockVersion = null)
 * @method RetombeMediatique|null findOneBy(array $criteria, array $orderBy = null)
 * @method RetombeMediatique[]    findAll()
 * @method RetombeMediatique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RetombeMediatiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RetombeMediatique::class);
    }

    // /**
    //  * @return RetombeMediatique[] Returns an array of RetombeMediatique objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RetombeMediatique
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
