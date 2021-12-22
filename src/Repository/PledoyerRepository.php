<?php

namespace App\Repository;

use App\Entity\Pledoyer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pledoyer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pledoyer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pledoyer[]    findAll()
 * @method Pledoyer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PledoyerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pledoyer::class);
    }

    // /**
    //  * @return Pledoyer[] Returns an array of Pledoyer objects
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
    public function findOneBySomeField($value): ?Pledoyer
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
