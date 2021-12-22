<?php

namespace App\Repository;

use App\Entity\VideoPledoyer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VideoPledoyer|null find($id, $lockMode = null, $lockVersion = null)
 * @method VideoPledoyer|null findOneBy(array $criteria, array $orderBy = null)
 * @method VideoPledoyer[]    findAll()
 * @method VideoPledoyer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoPledoyerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideoPledoyer::class);
    }

    // /**
    //  * @return VideoPledoyer[] Returns an array of VideoPledoyer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VideoPledoyer
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
