<?php

namespace App\Filter;

use App\Enum\BookingStatus;

class TicketPaymentFilter
{
    public ?string $searchParam = null;

    public ?BookingStatus $status = null;

    public function getStatus(): ?BookingStatus
    {
        return $this->status;
    }

    public function setStatus(?BookingStatus $status): void
    {
        $this->status = $status;
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
