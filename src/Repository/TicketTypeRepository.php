<?php

namespace App\Repository;

use App\Entity\TicketType;
use App\Filter\TicketTypeFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TicketType>
 */
class TicketTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TicketType::class);
    }

    public function getSoldTickets(TicketType $ticketType): int
    {
        return (int) $this->createQueryBuilder('t')
            ->select('COUNT(i.id)')
            ->leftJoin('t.issuedTickets', 'i')
            ->andWhere('i.ticketType = :ticketType')
            ->setParameter('ticketType', $ticketType)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getTicketTypesQueryBuilder(?TicketTypeFilter $filter): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->leftJoin('t.festival', 'f')
            ->orderBy('t.name', 'ASC');

        if ($filter) {
            if ($filter->getSearchParam()) {
                $queryBuilder
                    ->andWhere('t.name LIKE :searchTerm OR f.name LIKE :searchTerm')
                    ->setParameter('searchTerm', '%' . $filter->getSearchParam() . '%');
            }

            if ($filter->getMinTickets()) {
                $queryBuilder
                    ->andWhere('t.totalTickets >= :minTickets')
                    ->setParameter('minTickets', $filter->getMinTickets());
            }

            if ($filter->getMaxTickets()) {
                $queryBuilder
                    ->andWhere('t.totalTickets <= :maxTickets')
                    ->setParameter('maxTickets', $filter->getMaxTickets());
            }

            if ($filter->getMinPrice()) {
                $queryBuilder
                    ->andWhere('t.price >= :minPrice')
                    ->setParameter('minPrice', $filter->getMinPrice());
            }

            if ($filter->getMaxPrice()) {
                $queryBuilder
                    ->andWhere('t.price <= :maxPrice')
                    ->setParameter('maxPrice', $filter->getMaxPrice());
            }
        }

        return $queryBuilder;
    }

    //    /**
    //     * @return TicketType[] Returns an array of TicketType objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?TicketType
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
