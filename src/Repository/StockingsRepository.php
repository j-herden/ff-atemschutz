<?php

namespace App\Repository;

use App\Entity\DeviceTypes;
use App\Entity\Location;
use App\Entity\Organisation;
use App\Entity\Stockings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
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

    public function findCurrent(): array
    {
        return $this->createQueryBuilder('s')
            ->select('s.date, s.device_id')
            ->andWhere('s.removed = :removed')
            ->setParameter('removed', false)
            ->leftJoin('s.position', 'pos')
            ->addSelect('pos.Name as posName')
            ->leftJoin(DeviceTypes::class, 'dt', Join::WITH, 'dt.id = pos.deviceType')
            ->addSelect('dt.Name as dtName, dt.color as dtColor')
            ->leftJoin(Location::class, 'loc', Join::WITH, 'loc.id = pos.Location')
            ->addSelect('loc.Name as locName')
            ->leftJoin(Organisation::class, 'org', Join::WITH, 'org.id = loc.organisation')
            ->addSelect('org.Name as orgName, org.color as orgColor')
            ->orderBy('org.Name', 'ASC')
            ->addOrderBy('dt.Name', 'ASC')
            ->addOrderBy('loc.Name', 'ASC')
            ->addOrderBy('pos.Name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
