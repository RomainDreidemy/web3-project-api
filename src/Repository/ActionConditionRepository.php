<?php

namespace App\Repository;

use App\Entity\ActionCondition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
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


    public function findBySensorTypeAndFamily(int $sensorTypeId, int $familyId): array
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.family', 'f')
            ->innerJoin('a.sensorType', 's')
            ->where('s.id = :sensorTypeId')
            ->andWhere('f.id = :familyId')
            ->setParameters([
                'sensorTypeId' => $sensorTypeId,
                'familyId' => $familyId
            ])
            ->getQuery()
            ->getResult()
        ;
    }

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
