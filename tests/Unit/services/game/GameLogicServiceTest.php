<?php

namespace Tests\Unit\services\game;

use App\Models\Movie;
use App\Services\game\GameLogicService;
use App\Services\movie\MovieScoreService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class GameLogicServiceTest extends TestCase
{
    use DatabaseTransactions;

    /** @var MovieScoreService $movieScoreService */
    private $movieScoreService;

    /** @var GameLogicService $gameLogicService */
    private $gameLogicService;

    /** @var \ReflectionClass $gameLogicReflected */
    private $gameLogicReflected;

    protected function setUp(): void
    {
        parent::setUp();

        $this->movieScoreService = app()->make(MovieScoreService::class);
        $this->gameLogicService = app()->make(GameLogicService::class);
        $this->gameLogicReflected = new \ReflectionClass(GameLogicService::class);
    }

    /**
     * Tests we are able to create a game
     *
     * @return void
     */
    public function testCreateGameStructure()
    {
        $movies = Movie::factory()
            ->count(Config::get('app.game.NUMBER_STEPS'))
            ->create()
            ->map(function ($movie) {
                /** @var Movie $movie */
                return [
                    'id' => $movie->id,
                    'title' => $movie->title,
                    'guessing' => $this->movieScoreService->generateRandomScore(),
                    'score' => $movie->score,
                ];
            });;

        $game = $this->gameLogicService->createGame($movies->toArray());

        $this->assertArrayHasKey('results', $game);
        $this->assertArrayHasKey('finalScore', $game);
    }

    /**
     * Test that the guess is correct
     *
     * @return void
     */
    public function testGuessIsCorrect()
    {
        // We could have tested everything into testCreateGameStructure
        // but I had problems asserting the value of the $game array
        // so that's why I'm testing each method separately

        // Since GameLogicService::guessedCorrect is a private method
        // we will use reflection to set the method to public
        // visibility to be able to use it.
        $method = $this->gameLogicReflected->getMethod('guessedCorrect');
        $method->setAccessible(true);
        $guessedCorrect = $method->invokeArgs(new GameLogicService(), [1.2, 1]);

        $this->assertTrue($guessedCorrect);

        $guessedCorrect = $method->invokeArgs(new GameLogicService(), [4, 1]);
        $this->assertFalse($guessedCorrect);
    }

    /**
     *  Test the boundary is being returned from app configuration
     *
     * @return void
     */
    public function testBoundaryIsBeingReturnedFromAppConfiguration()
    {
        $method = $this->gameLogicReflected->getMethod('boundary');
        $method->setAccessible(true);
        $boundary = $method->invoke(new GameLogicService());

        $this->assertTrue($boundary === Config::get('app.game.BOUNDARY_GUESS'));
    }

    /**
     * Tests the buildResult is returning the expected array format
     *
     * @return void
     */
    public function testBuildResultIsReturningExpectedArrayFormat()
    {
        $movie = Movie::factory()->create();
        $randomScore = $this->movieScoreService->generateRandomScore();

        $method = $this->gameLogicReflected->getMethod('guessedCorrect');
        $method->setAccessible(true);
        $guessedCorrect = $method->invokeArgs(new GameLogicService(), [$randomScore, $movie->score]);

        $method = $this->gameLogicReflected->getMethod('buildResult');
        $method->setAccessible(true);
        $builtResult = $method->invokeArgs(
            new GameLogicService(),
            [
                array_merge(['guessing' => $randomScore], $movie->toArray()),
                $guessedCorrect,
            ]
        );

        $expectedResult = [
            'id' => $movie->id,
            'title' => $movie->title,
            'guessed' => $guessedCorrect,
            'guessing' => $randomScore,
            'score' => $movie->score
        ];
        $this->assertIsArray($builtResult);
        $this->assertEquals($builtResult, $expectedResult);
    }
}
