<?php

namespace App\Repository;

use App\Entity\Stockings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stockings|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stockings|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stockings[]    findAll()
 * @method Stockings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stockings::class);
    }

    /**
     * @return Stockings[] Returns an array of Stockings objects
     */
    public function currentByOrganisation() : array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.removed = :removed')
            ->setParameter('removed', false)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Stockings
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
