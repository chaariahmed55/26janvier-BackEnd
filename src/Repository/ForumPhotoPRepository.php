<?php

namespace App\Repository;

use App\Entity\ForumPhotoP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ForumPhotoP|null find($id, $lockMode = null, $lockVersion = null)
 * @method ForumPhotoP|null findOneBy(array $criteria, array $orderBy = null)
 * @method ForumPhotoP[]    findAll()
 * @method ForumPhotoP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForumPhotoPRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ForumPhotoP::class);
    }

    // /**
    //  * @return ForumPhotoP[] Returns an array of ForumPhotoP objects
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
    public function findOneBySomeField($value): ?ForumPhotoP
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
