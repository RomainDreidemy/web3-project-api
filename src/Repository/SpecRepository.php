<?php

namespace App\Repository;

use App\Entity\Spec;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Spec|null find($id, $lockMode = null, $lockVersion = null)
 * @method Spec|null findOneBy(array $criteria, array $orderBy = null)
 * @method Spec[]    findAll()
 * @method Spec[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Spec::class);
    }

    // /**
    //  * @return SpecFixtures[] Returns an array of SpecFixtures objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SpecFixtures
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
