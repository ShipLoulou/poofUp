<?php

namespace App\Repository;

use DateTime;
use App\Entity\Event;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findNextEvent($category = null): ?Event
    {
        $now = new DateTime();

        $query = $this->createQueryBuilder('e')
            ->andWhere('e.raceDate > :val')
            ->setParameter('val', $now)
            ->orderBy('e.raceDate', 'ASC')
            ->setMaxResults(1);

        if ($category !== null) {
            $query->andWhere('e.category = :category')
                ->setParameter('category', $category);
        }

        return $query->getQuery()->getOneOrNullResult();
    }

    public function findByCategory($value): array
    {
        $query = $this->createQueryBuilder('e')
            ->andWhere('e.category = :val')
            ->setParameter('val', $value)
            ->orderBy('e.startDate', 'ASC');

        return $query->getQuery()->getResult();
    }

    public function findWithFilterParametter($category = null, $season = null, $sort = null): array
    {
        $query = $this->createQueryBuilder('e');

        if ($category !== "" && $category !== null) {
            $query->andWhere('e.category = :category')
                ->setParameter('category', $category);
        }

        if ($season !== "" && $season !== null) {
            $query->andWhere('e.currentSeason = :season')
                ->setParameter('season', $season);
        }

        if ($sort === 'Date') {
            $query->orderBy('e.raceDate', 'ASC');
        }


        return $query->getQuery()->getResult();
    }

    //    /**
    //     * @return Event[] Returns an array of Event objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Event
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
