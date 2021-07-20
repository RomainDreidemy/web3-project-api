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

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneBySensorTypeAndFamily(int $sensorTypeId, int $familyId): ?Spec
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.familly', 'f')
            ->innerJoin('s.sensorType', 't')

            ->where('t.id = :sensorTypeId')
            ->andWhere('f.id = :familyId')
            ->setParameters([
                'sensorTypeId' => $sensorTypeId,
                'familyId' => $familyId
            ])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Spec
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
