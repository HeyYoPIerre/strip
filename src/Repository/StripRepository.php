<?php

namespace App\Repository;

use App\Entity\Strip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Strip>
 *
 * @method Strip|null find($id, $lockMode = null, $lockVersion = null)
 * @method Strip|null findOneBy(array $criteria, array $orderBy = null)
 * @method Strip[]    findAll()
 * @method Strip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StripRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Strip::class);
    }

//    /**
//     * @return Strip[] Returns an array of Strip objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Strip
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
