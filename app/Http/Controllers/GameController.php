<?php

namespace App\Http\Controllers;

use App\Http\Requests\GamePost;
use App\Http\Resources\GameCollection;
use App\Http\Resources\GameResource;
use App\Services\game\CreateGameService;
use App\Services\game\IndexGameService;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(Request $request, IndexGameService $indexGameService)
    {
        $games = $indexGameService->index(
            $request->get('filters') ?? [],
            $request->get('sort') ?? '',
        );

        return new GameCollection($games);
    }

    public function store(GamePost $request, CreateGameService $createGameService)
    {
        $game = $createGameService->create($request->all());

        return new GameResource($game);
    }
}
