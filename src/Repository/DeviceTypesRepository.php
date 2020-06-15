<?php

namespace App\Repository;

use App\Entity\DeviceTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DeviceTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeviceTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeviceTypes[]    findAll()
 * @method DeviceTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeviceTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeviceTypes::class);
    }

    // /**
    //  * @return DeviceTypes[] Returns an array of DeviceTypes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DeviceTypes
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
