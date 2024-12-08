<?php

namespace App\Repository;

use App\Entity\Pilot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pilot>
 */
class PilotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pilot::class);
    }

    public function findByCategory($category, $numberResult = null): array
    {
        $query = $this->createQueryBuilder('p')
            ->andWhere('p.category = :category')
            ->setParameter('category', $category)
            ->orderBy('p.seasonTotalPoint', 'DESC');

        if ($numberResult) {
            $query->setMaxResults($numberResult);
        }

        return $query->getQuery()->getResult();
    }

    public function findAllByCategory($category): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.category = :category')
            ->setParameter('category', $category)
            ->orderBy('p.seasonTotalPoint', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findWithFilterParametter($category = null, $season = null, $sort = null): array
    {
        $query = $this->createQueryBuilder('p');

        if ($category !== "" && $category !== null) {
            $query->andWhere('p.category = :category')
                ->setParameter('category', $category);
        }

        if ($season !== "" && $season !== null) {
            $query->andWhere('p.currentSeason = :season')
                ->setParameter('season', $season);
        }

        if ($sort === 'fullname') {
            $query->orderBy('p.fullName', 'ASC');
        }


        return $query->getQuery()->getResult();
    }

    //    /**
    //     * @return Pilot[] Returns an array of Pilot objects
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

    //    public function findOneBySomeField($value): ?Pilot
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
