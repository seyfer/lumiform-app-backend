<?php

namespace App\Services\term;

use App\Models\Movie;
use App\Models\Term;
use App\Services\thirdPartyApis\factory\FetchMoviesFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class CreateTermService
{
    private $fetchMovies;

    public function __construct()
    {
        $this->fetchMovies = FetchMoviesFactory::getFactory();
    }

    public function create(array $data)
    {
        $term = $this->fetchTerm($data);

        if ($this->needsRefreshResults($term)) {
            $results = $this->fetchMovies->fetchBySearchingTitle($data['term']);
            $this->saveResults($results, $term);
            $term->update(['last_used_at' => Carbon::now()]);
        }

        $numberMovies = $term->movies()->count();
        if (!$this->hasEnoughResults($numberMovies)) {
            abort(
                Response::HTTP_EXPECTATION_FAILED,
                'Provide a term with enough movies. This term only has ' . $numberMovies . ' movies'
            );
        }

        // We are assuming that we will only have
        // around 10 movies per each term
        // so no need to worry about
        // loading too many records
        $term->load('movies');

        return $term;
    }

    private function needsRefreshResults(Term $term)
    {
        if (is_null($term->last_used_at)) {
            return true;
        }

        return $term->last_used_at->diffInMinutes(Carbon::now()) > Config::get('cache.app.CACHE_TERMS_MINUTES');
    }

    private function saveResults(array $response, Term $term)
    {
        foreach ($response['data'] as $search) {
            Movie::create(
                array_merge(
                    ['term_id' => $term->id],
                    $this->fetchMovies->normalizeEntity($search)
                )
            );
        }
    }

    private function fetchTerm(array $data)
    {
        /** @var Term $term */
        $term = Term::firstOrCreate(['term' => $data['term']]);

        return $term;
    }

    private function hasEnoughResults(int $numberResults)
    {
        return $numberResults >= Config::get('app.game.NUMBER_STEPS');
    }
}
