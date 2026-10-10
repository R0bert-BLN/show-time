<?php

namespace App\Filter;

use App\Entity\Location;

class FestivalFilter
{
    public ?\DateTime $startDate = null;
    public ?\DateTime $endDate = null;
    public ?string $searchParam = null;

    public function getSearchParam(): ?string
    {
        return $this->searchParam;
    }

    public function setSearchParam(?string $searchParam): void
    {
        $this->searchParam = $searchParam;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }
}
