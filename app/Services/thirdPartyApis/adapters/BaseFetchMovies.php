<?php

namespace App\Services\thirdPartyApis\adapters;

abstract class BaseFetchMovies
{
    /**
     * It is responsible to normalize the response returned by the adapter
     * so FetchMoviesContract::fetchBySearchingTitle() returns a consistent response
     *
     * @param array $response
     * @return array
     */
    abstract function normalizeResponse(array $response): array;

    /**
     * This method is response to receive a result from third party API
     * and transform into our internal representation of a movie
     *
     * @param array $item
     * @return array
     */
    abstract function normalizeEntity(array $item): array;
}
