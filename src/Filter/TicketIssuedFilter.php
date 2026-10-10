<?php

namespace App\Filter;

use App\Enum\IssuedTicketStatus;

class TicketIssuedFilter
{
    public ?string $searchParam = null;

    public ?IssuedTicketStatus $status = null;

    public function getStatus(): ?IssuedTicketStatus
    {
        return $this->status;
    }

    public function setStatus(?IssuedTicketStatus $status): void
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
