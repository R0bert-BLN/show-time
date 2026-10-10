<?php

namespace App\Repository;

use App\Entity\IssuedTicket;
use App\Filter\TicketIssuedFilter;
use App\Filter\TicketPaymentFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IssuedTicket>
 */
class IssuedTicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IssuedTicket::class);
    }

    public function findByTransactionId($value): array
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.booking', 'b')
            ->andWhere('b.transactionId = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getIssuedTicketsQueryBuilder(?TicketIssuedFilter $filter): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('i')
            ->leftJoin('i.booking', 'b')
            ->leftJoin('i.ticketType', 't')
            ->leftJoin('t.festival', 'f');

        if ($filter) {
            if ($filter->getSearchParam()) {
                $queryBuilder
                    ->andWhere('i.qrCodeId LIKE :searchTerm OR t.name LIKE :searchTerm OR f.name LIKE :searchTerm OR b.transactionId LIKE :searchTerm')
                    ->setParameter('searchTerm', '%' . $filter->getSearchParam() . '%');
            }

            if ($filter->getStatus()) {
                $queryBuilder
                    ->andWhere('i.status LIKE :status')
                    ->setParameter('status', $filter->getStatus());
            }
        }

        return $queryBuilder;
    }
}
