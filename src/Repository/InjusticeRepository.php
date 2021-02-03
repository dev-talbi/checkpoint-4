<?php

namespace App\Repository;

use App\Entity\Injustice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Injustice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Injustice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Injustice[]    findAll()
 * @method Injustice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InjusticeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Injustice::class);
    }

    // /**
    //  * @return Injustice[] Returns an array of Injustice objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Injustice
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
