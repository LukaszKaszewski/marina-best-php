<?php

namespace App\Repository;

use App\Entity\Wintering;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Wintering>
 *
 * @method Wintering|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wintering|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wintering[]    findAll()
 * @method Wintering[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WinteringRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wintering::class);
    }

//    /**
//     * @return Wintering[] Returns an array of Wintering objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Wintering
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
