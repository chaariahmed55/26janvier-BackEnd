<?php

namespace App\Repository;

use App\Entity\PhotoProjectionDebat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PhotoProjectionDebat|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotoProjectionDebat|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotoProjectionDebat[]    findAll()
 * @method PhotoProjectionDebat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoProjectionDebatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhotoProjectionDebat::class);
    }

    // /**
    //  * @return PhotoProjectionDebat[] Returns an array of PhotoProjectionDebat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PhotoProjectionDebat
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
