<?php

namespace App\Repository;

use App\Entity\ActionCondition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ActionCondition|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActionCondition|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActionCondition[]    findAll()
 * @method ActionCondition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActionConditionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActionCondition::class);
    }

    // /**
    //  * @return ActionCondition[] Returns an array of ActionCondition objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ActionCondition
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
