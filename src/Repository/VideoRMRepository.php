<?php

namespace App\Repository;

use App\Entity\VideoRM;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VideoRM|null find($id, $lockMode = null, $lockVersion = null)
 * @method VideoRM|null findOneBy(array $criteria, array $orderBy = null)
 * @method VideoRM[]    findAll()
 * @method VideoRM[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoRMRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideoRM::class);
    }

    // /**
    //  * @return VideoRM[] Returns an array of VideoRM objects
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
    public function findOneBySomeField($value): ?VideoRM
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
