<?php

namespace App\Repository;

use App\Entity\MapPlace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MapPlace|null find($id, $lockMode = null, $lockVersion = null)
 * @method MapPlace|null findOneBy(array $criteria, array $orderBy = null)
 * @method MapPlace[]    findAll()
 * @method MapPlace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MapPlaceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MapPlace::class);
    }

    // /**
    //  * @return MapPlace[] Returns an array of MapPlace objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MapPlace
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
