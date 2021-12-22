<?php

namespace App\Repository;

use App\Entity\PhotoRM;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PhotoRM|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotoRM|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotoRM[]    findAll()
 * @method PhotoRM[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoRMRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhotoRM::class);
    }

    // /**
    //  * @return PhotoRM[] Returns an array of PhotoRM objects
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
    public function findOneBySomeField($value): ?PhotoRM
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
