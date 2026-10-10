<?php

namespace App\Filter;

class BandFilter
{
    public ?string $searchParam = null;
    public array $genres = [];

    public function getGenres(): array
    {
        return $this->genres;
    }

    public function setGenres(array $genres): void
    {
        $this->genres = $genres;
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
