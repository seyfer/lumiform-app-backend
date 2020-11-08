<?php

namespace App\Services\game;

use App\Models\Game;

class IndexGameService
{
    public function index(array $filters, string $sorts)
    {
        $game = Game::with(['term', 'user']);

        // @todo: if there is time create a service to handle filtering in all models
        // or use https://github.com/Tucker-Eric/EloquentFilter
        if (strpos($sorts, '-final_score') !== false) {
            $game = $game
                ->orderBy('final_score')
                ->orderBy('created_at');
        } else if (strpos($sorts, 'final_score') !== false) {
            // If we have two equals final_score the user that
            // played first will be considered higher in the leaderboard
            $game = $game
                ->orderByDesc('final_score')
                ->orderBy('created_at');
        }

        return $game->paginate(10);
    }
}
