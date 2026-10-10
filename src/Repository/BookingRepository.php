<?php

namespace App\Repository;

use App\Entity\Booking;
use App\Filter\TicketPaymentFilter;
use App\Filter\TicketTypeFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Booking>
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function getTicketPaymentsQueryBuilder(?TicketPaymentFilter $filter): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('b')
            ->leftJoin('b.user', 'u');

        if ($filter) {
            if ($filter->getSearchParam()) {
                $queryBuilder
                    ->andWhere('b.transactionId LIKE :searchTerm OR u.email LIKE :searchTerm')
                    ->setParameter('searchTerm', '%' . $filter->getSearchParam() . '%');
            }

            if ($filter->getStatus()) {
                $queryBuilder
                    ->andWhere('b.status LIKE :status')
                    ->setParameter('status', $filter->getStatus());
            }
        }

        return $queryBuilder;
    }

//    /**
//     * @return Booking[] Returns an array of Booking objects
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

//    public function findOneBySomeField($value): ?Booking
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
