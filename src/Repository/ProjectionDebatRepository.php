<?php

namespace App\Repository;

use App\Entity\ProjectionDebat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProjectionDebat|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectionDebat|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectionDebat[]    findAll()
 * @method ProjectionDebat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectionDebatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectionDebat::class);
    }

    // /**
    //  * @return ProjectionDebat[] Returns an array of ProjectionDebat objects
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
    public function findOneBySomeField($value): ?ProjectionDebat
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
