<?php

namespace App\Repository;

use App\Entity\Place;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Place>
 *
 * @method Place|null find($id, $lockMode = null, $lockVersion = null)
 * @method Place|null findOneBy(array $criteria, array $orderBy = null)
 * @method Place[]    findAll()
 * @method Place[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Place::class);
    }

//    /**
//     * @return Place[] Returns an array of Place objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Place
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findByIsTaken($sd, $ed)
    {
        // wyszukiwanie zajętych pozycji
        $busyPlaces = $this->createQueryBuilder('p')
            ->andWhere('p.start_date <= :end_date')
            ->andWhere('p.end_date >= :start_date')
            ->setParameter('start_date', $sd)
            ->setParameter('end_date', $ed)
            ->getQuery()
            ->getResult();

        // w talicy zapisuje zajete pozycje
        $busyPlaceNumbers = [];
        foreach ($busyPlaces as $place) {
            $busyPlaceNumbers[] = $place->getNumber();
        }

        // odwraca tablice pokazujac wolne miejsca
        $availablePlaces = [];
        for ($i = 1; $i <= 120; $i++) {
            if (!in_array($i, $busyPlaceNumbers)) {
                $availablePlaces[] = $i;
            }
        }

        return $availablePlaces;
    }
}
