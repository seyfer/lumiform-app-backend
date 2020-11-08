<?php

namespace Tests\Unit\services\user;

use App\Services\user\CreateUserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CreateUserServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @var CreateUserService $createUserService */
    private $createUserService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createUserService = app()->make(CreateUserService::class);
    }

    /**
     * Test can create user
     *
     * @return void
     */
    public function testCanCreateUser()
    {
        $data = ['username' => rand(1, 5) . rand(1, 1000)];

        $this->createUserService->create($data);

        $this->assertDatabaseHas('users', [
            'username' => $data['username']
        ]);
    }

    /**
     * Test we can't have two users with same username
     *
     * @return void
     */
    public function testCantCreateSameUserTwice()
    {
        $data = ['username' => rand(1, 5) . rand(1, 1000)];

        $this->createUserService->create($data);

        $this->assertDatabaseHas('users', [
            'username' => $data['username']
        ]);

        $this->expectException(HttpException::class);
        $this->createUserService->create($data);
    }
}
