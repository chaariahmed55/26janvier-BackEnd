<?php

namespace App\Repository;

use App\Entity\VideoArchive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VideoArchive|null find($id, $lockMode = null, $lockVersion = null)
 * @method VideoArchive|null findOneBy(array $criteria, array $orderBy = null)
 * @method VideoArchive[]    findAll()
 * @method VideoArchive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoArchiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideoArchive::class);
    }

    // /**
    //  * @return VideoArchive[] Returns an array of VideoArchive objects
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
    public function findOneBySomeField($value): ?VideoArchive
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
