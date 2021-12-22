<?php

namespace App\Repository;

use App\Entity\OtherResouce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OtherResouce|null find($id, $lockMode = null, $lockVersion = null)
 * @method OtherResouce|null findOneBy(array $criteria, array $orderBy = null)
 * @method OtherResouce[]    findAll()
 * @method OtherResouce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OtherResouceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OtherResouce::class);
    }

    // /**
    //  * @return OtherResouce[] Returns an array of OtherResouce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OtherResouce
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
