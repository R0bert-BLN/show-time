<?php

namespace App\Filter;

class TicketTypeFilter
{
    public ?string $searchParam = null;
    public ?int $minTickets = null;
    public ?int $maxTickets = null;
    public ?float $minPrice = null;
    public ?float $maxPrice = null;

    public function getMinTickets(): ?int
    {
        return $this->minTickets;
    }

    public function setMinTickets(?int $minTickets): void
    {
        $this->minTickets = $minTickets;
    }

    public function getMaxTickets(): ?int
    {
        return $this->maxTickets;
    }

    public function setMaxTickets(?int $maxTickets): void
    {
        $this->maxTickets = $maxTickets;
    }

    public function getMinPrice(): ?float
    {
        return $this->minPrice;
    }

    public function setMinPrice(?float $minPrice): void
    {
        $this->minPrice = $minPrice;
    }

    public function getMaxPrice(): ?float
    {
        return $this->maxPrice;
    }

    public function setMaxPrice(?float $maxPrice): void
    {
        $this->maxPrice = $maxPrice;
    }

    public function getSearchParam(): ?string
    {
        return $this->searchParam;
    }

    public function setSearchParam(?string $searchParam): void
    {
        $this->searchParam = $searchParam;
    }
}
