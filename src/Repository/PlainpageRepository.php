<?php

namespace App\Repository;

use App\Entity\Plainpage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Plainpage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Plainpage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Plainpage[]    findAll()
 * @method Plainpage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlainpageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Plainpage::class);
    }

    // /**
    //  * @return Plainpage[] Returns an array of Plainpage objects
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
    public function findOneBySomeField($value): ?Plainpage
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
