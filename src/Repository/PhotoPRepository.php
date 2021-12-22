<?php

namespace App\Repository;

use App\Entity\PhotoP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PhotoP|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotoP|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotoP[]    findAll()
 * @method PhotoP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoPRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhotoP::class);
    }

    // /**
    //  * @return PhotoP[] Returns an array of PhotoP objects
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
    public function findOneBySomeField($value): ?PhotoP
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
