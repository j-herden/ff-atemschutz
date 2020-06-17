<?php

namespace App\Repository;

use App\Entity\Positions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Positions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Positions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Positions[]    findAll()
 * @method Positions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PositionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Positions::class);
    }

    // /**
    //  * @return Positions[] Returns an array of Positions objects
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
    public function findOneBySomeField($value): ?Positions
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
