<?php

namespace App\Repository;

use App\Entity\PhotoBrochure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PhotoBrochure|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotoBrochure|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotoBrochure[]    findAll()
 * @method PhotoBrochure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoBrochureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhotoBrochure::class);
    }

    // /**
    //  * @return PhotoBrochure[] Returns an array of PhotoBrochure objects
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
    public function findOneBySomeField($value): ?PhotoBrochure
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
