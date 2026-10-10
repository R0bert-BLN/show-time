<?php

namespace App\Repository;

use App\Entity\Festival;
use App\Filter\FestivalFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Festival>
 */
class FestivalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Festival::class);
    }

    public function findTopFestivals(int $limit = 3): array
    {
        return $this->createQueryBuilder('f')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function getFestivalsQueryBuilder(?FestivalFilter $filter): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('f')
            ->leftJoin('f.location', 'l')
            ->orderBy('f.name', 'ASC');

        if ($filter) {
            if ($filter->getStartDate()) {
                $queryBuilder
                    ->andWhere('f.startDate >= :startDate')
                    ->setParameter('startDate', $filter->getStartDate());
            }

            if ($filter->getEndDate()) {
                $queryBuilder
                    ->andWhere('f.endDate <= :endDate')
                    ->setParameter('endDate', $filter->getEndDate());
            }

            if ($filter->getSearchParam()) {
                $queryBuilder
                    ->andWhere('f.name LIKE :searchParam OR l.city LIKE :searchParam')
                    ->setParameter('searchParam', '%' . $filter->getSearchParam() . '%');
            }
        }

        return $queryBuilder;
    }

    //    /**
    //     * @return FestivalFixtures[] Returns an array of FestivalFixtures objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?FestivalFixtures
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
