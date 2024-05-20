<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Place;
use App\Form\PlaceType;
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

    public function reservation()
    {
        // wyszukiwanie zajętych pozycji
        return $this->createQueryBuilder('p')
            ->select('p.start_date', 'p.end_date', 'p.number', 'p.boat_name', 'u.username')
            ->join('p.user', 'u')
            ->getQuery()
            ->getResult();
        }

    public function reservationByStartDate()
    {
        // search reservation by start date
        return $this->createQueryBuilder('p')
            ->select('p.id', 'p.start_date', 'p.end_date', 'p.number', 'p.boat_name', 'u.username', 'k.key_number')
            ->join('p.user', 'u')
            ->join('p.key_number', 'k')
            ->orderBy('p.start_date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function checkNewPlaces($sd, $ed, $num)
    {
        // search conflict position
        $busyPlaces = $this->createQueryBuilder('p')
            ->andWhere('p.number = :number')
            ->andWhere('p.end_date >= :start_date')
            ->andWhere('p.start_date <= :end_date')
            ->setParameter('number', $num)
            ->setParameter('start_date', $sd)
            ->setParameter('end_date', $ed)
            ->getQuery()
            ->getResult();

        // array with conflict position
        // if null -> add new entry
        $busyPlaceNumbers = [];
        foreach ($busyPlaces as $place) {
            $busyPlaceNumbers[] = $place->getNumber();
        }

        return $busyPlaceNumbers;
    }






}
