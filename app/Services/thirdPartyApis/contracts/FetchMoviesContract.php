<?php

namespace App\Services\thirdPartyApis\contracts;

interface FetchMoviesContract
{
    public function fetchBySearchingTitle(string $term);
    public function normalizeEntity(array $item);
}
