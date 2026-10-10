<?php

namespace App\Repository;

use App\Entity\Band;
use App\Filter\BandFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Band>
 */
class BandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Band::class);
    }

    public function getBandsQueryBuilder(?BandFilter $filter): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('b')
            ->orderBy('b.name', 'ASC');

        if ($filter) {
            if ($filter->getSearchParam()) {
                $queryBuilder
                    ->andWhere('b.name LIKE :searchTerm OR b.genre LIKE :searchTerm')
                    ->setParameter('searchTerm', '%' . $filter->getSearchParam() . '%');
            }

            if ($filter->getGenres()) {
                $queryBuilder
                    ->andWhere('b.genre IN (:genres)')
                    ->setParameter('genres', $filter->getGenres());
            }
        }

        return $queryBuilder;
    }

    //    /**
    //     * @return Band[] Returns an array of Band objects
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

    //    public function findOneBySomeField($value): ?Band
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
