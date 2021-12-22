<?php

namespace App\Repository;

use App\Entity\PhotoRapport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PhotoRapport|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotoRapport|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotoRapport[]    findAll()
 * @method PhotoRapport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoRapportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhotoRapport::class);
    }

    // /**
    //  * @return PhotoRapport[] Returns an array of PhotoRapport objects
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
    public function findOneBySomeField($value): ?PhotoRapport
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
