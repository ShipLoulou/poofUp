<?php

namespace App\Repository;

use App\Entity\Constructor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Constructor>
 */
class ConstructorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Constructor::class);
    }

    public function findByCategory($category, $numberResult = null): array
    {
        $query = $this->createQueryBuilder('c')
            ->andWhere('c.category = :category')
            ->setParameter('category', $category)
            ->orderBy('c.seasonTotalPoint', 'DESC');

        if ($numberResult) {
            $query->setMaxResults($numberResult);
        }

        return $query->getQuery()->getResult();
    }

    public function findAllByCategory($category): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.category = :category')
            ->setParameter('category', $category)
            ->orderBy('c.seasonTotalPoint', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findWithFilterParametter($category = null, $season = null, $sort = null): array
    {
        $query = $this->createQueryBuilder('c');

        if ($category !== "" && $category !== null) {
            $query->andWhere('c.category = :category')
                ->setParameter('category', $category);
        }

        if ($season !== "" && $season !== null) {
            $query->andWhere('c.currentSeason = :season')
                ->setParameter('season', $season);
        }

        if ($sort === 'fullname') {
            $query->orderBy('c.fullName', 'ASC');
        }


        return $query->getQuery()->getResult();
    }

    //    /**
    //     * @return Constructor[] Returns an array of Constructor objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Constructor
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
