<?php

namespace App\Services\game;

use Illuminate\Support\Facades\Config;

class GameLogicService
{
    public function createGame(array $movies)
    {
        $finalScore = 0;
        $results = [];

        foreach ($movies as $movie) {
            $guessedCorrect = $this->guessedCorrect($movie['guessing'], $movie['score']);
            $results[] = $this->buildResult($movie, $guessedCorrect);

            if ($guessedCorrect) {
                $finalScore += 1;
            }
        }

        return [
            'finalScore' => $finalScore,
            'results' => $results,
        ];
    }

    private function guessedCorrect(float $guessedScore, float $movieScore)
    {
        $min = $guessedScore - $this->boundary();
        $max = $guessedScore + $this->boundary();

        return ($min <= $movieScore) && ($movieScore <= $max);
    }

    private function boundary()
    {
        return Config::get('app.game.BOUNDARY_GUESS');
    }

    private function buildResult(array $movie, bool $guessedCorrect)
    {
        return [
            'id' => $movie['id'],
            'title' => $movie['title'],
            'guessed' => $guessedCorrect,
            'guessing' => $movie['guessing'],
            'score' => $movie['score'],
        ];
    }
}
