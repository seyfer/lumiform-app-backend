<?php

namespace App\Services\thirdPartyApis\factory;

use App\Services\thirdPartyApis\adapters\FetchMoviesContractIMDBAdapter;
use App\Services\thirdPartyApis\contracts\FetchMoviesContract;

class FetchMoviesFactory
{
    public static function getFactory(): FetchMoviesContract {
        // Here we could define such logic to get which adapter
        // we would live to resolve. An example would be:
        // We already used all our limits on API A
        // and needs to use B. We could apply the
        // logic here
        return new FetchMoviesContractIMDBAdapter();
    }
}
