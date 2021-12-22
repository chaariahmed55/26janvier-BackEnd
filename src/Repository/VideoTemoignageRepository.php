<?php

namespace App\Repository;

use App\Entity\VideoTemoignage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VideoTemoignage|null find($id, $lockMode = null, $lockVersion = null)
 * @method VideoTemoignage|null findOneBy(array $criteria, array $orderBy = null)
 * @method VideoTemoignage[]    findAll()
 * @method VideoTemoignage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoTemoignageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideoTemoignage::class);
    }

    // /**
    //  * @return VideoTemoignage[] Returns an array of VideoTemoignage objects
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
    public function findOneBySomeField($value): ?VideoTemoignage
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
