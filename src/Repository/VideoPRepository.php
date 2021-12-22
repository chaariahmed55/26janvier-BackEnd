<?php

namespace App\Repository;

use App\Entity\VideoP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VideoP|null find($id, $lockMode = null, $lockVersion = null)
 * @method VideoP|null findOneBy(array $criteria, array $orderBy = null)
 * @method VideoP[]    findAll()
 * @method VideoP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoPRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideoP::class);
    }

    // /**
    //  * @return VideoP[] Returns an array of VideoP objects
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
    public function findOneBySomeField($value): ?VideoP
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
