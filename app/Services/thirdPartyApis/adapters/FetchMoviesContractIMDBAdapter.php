<?php

namespace App\Services\thirdPartyApis\adapters;

use App\Services\movie\MovieScoreService;
use App\Services\thirdPartyApis\contracts\FetchMoviesContract;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class FetchMoviesContractIMDBAdapter extends BaseFetchMovies implements FetchMoviesContract
{
    private $httpClient;

    private $movieScoreService;

    public function __construct()
    {
        $this->movieScoreService = app()->make(MovieScoreService::class);
        $this->httpClient = new Client([
            'base_uri' => Config::get('app.third_party_apis.OMDB_API_URL'),
            'defaults' => [
                'query' => [
                    'apikey' => Config::get('app.third_party_apis.OMDB_API_KEY'),
                ]
            ]
        ]);
    }

    public function fetchBySearchingTitle(string $term)
    {
        // By OMDB api (http://www.omdbapi.com/) the query key `s` means:
        // Movie title to search for.
        $options = array_merge_recursive(['query' => ['s' => $term]], $this->httpClient->getConfig('defaults'));

        try {
            $guzzleResponse = $this->httpClient->get('/', $options ?? []);
        } catch (GuzzleException $exception) {
            abort(Response::HTTP_EXPECTATION_FAILED, 'There was an error fetching movies');
        }

        $decoded = json_decode($guzzleResponse->getBody()->getContents(), true);

        Log::debug(json_encode($decoded));

        if (array_key_exists('Error', $decoded)) {
            abort(Response::HTTP_EXPECTATION_FAILED, 'There was an error fetching movies: ' . $decoded['Error']);
        }

        $normalizedResponse = $this->normalizeResponse($decoded);

        return $normalizedResponse;
    }

    public function normalizeResponse(array $response): array
    {
        //todo: iterate first 5 responses and send requests
        // by IMDB ids to get the real IMDB ratings
        // tip: use generator

        return [
            'data' => $response['Search'],
            'meta' => [
                'total' => $response['totalResults'],
            ],
        ];
    }

    public function normalizeEntity(array $item): array
    {
        return [
            'poster' => $item['Poster'],
            'title' => $item['Title'],
            'score' => $this->movieScoreService->generateRandomScore()
        ];
    }
}
