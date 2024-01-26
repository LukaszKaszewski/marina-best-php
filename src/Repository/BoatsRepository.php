<?php

namespace App\Repository;

use App\Entity\Boats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Boats>
 *
 * @method Boats|null find($id, $lockMode = null, $lockVersion = null)
 * @method Boats|null findOneBy(array $criteria, array $orderBy = null)
 * @method Boats[]    findAll()
 * @method Boats[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoatsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Boats::class);
    }

//    /**
//     * @return Boats[] Returns an array of Boats objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Boats
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
