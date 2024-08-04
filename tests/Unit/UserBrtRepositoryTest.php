<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Userbrt;
use Illuminate\Support\Facades\Artisan;
use Mockery;


class UserBrtRepositoryTest extends TestCase
{
    use RefreshDatabase;
    private $user;
    private $userBrtService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->userBrtService = Mockery::mock(UserBrtService::class);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function it_can_create_a_userbrt()
    {
        $data = [
            'reserved_amount' => 100.00,
            'status' => 'active',
        ];

        $this->userBrtService
            ->shouldReceive('createBrt')
            ->with($this->user->id, $data)
            ->once()
            ->andReturn([
                'status' => true,
                'message' => 'User brt detail created successfully',
                'data' => [
                    'user_id' => $this->user->id,
                    'brt_code' => 'QZjxRDyqTd',
                    'reserved_amount' => 100.00,
                    'status' => 'active',
                ]
            ]);

        $response = $this->userBrtService->createBrt($this->user->id, $data);

        $this->assertTrue($response['status']);
        $this->assertEquals('User brt detail created successfully', $response['message']);
        $this->assertEquals($this->user->id, $response['data']['user_id']);
    }

    /** @test */
    public function it_can_list_all_userbrts()
    {
        $userbrts = Userbrt::factory()->count(3)->make(['user_id' => $this->user->id]);

        $this->userBrtService
            ->shouldReceive('getAllUserbrts')
            ->with($this->user->id)
            ->once()
            ->andReturn([
                'status' => true,
                'message' => 'User brt details fetched successfully',
                'data' => $userbrts
            ]);

        $response = $this->userBrtService->getAllUserbrts($this->user->id);

        $this->assertTrue($response['status']);
        $this->assertEquals('User brt details fetched successfully', $response['message']);
        $this->assertCount(3, $response['data']);
    }

    /** @test */
    public function it_can_show_a_userbrt()
    {
        $userbrt = Userbrt::factory()->create(['user_id' => $this->user->id]);

        $this->userBrtService
            ->shouldReceive('getUserbrt')
            ->with($this->user->id, $userbrt->id)
            ->once()
            ->andReturn([
                'status' => true,
                'message' => 'User brt detail fetched successfully',
                'data' => $userbrt
            ]);

        $response = $this->userBrtService->getUserbrt($this->user->id, $userbrt->id);

        $this->assertTrue($response['status']);
        $this->assertEquals('User brt detail fetched successfully', $response['message']);
        $this->assertEquals($userbrt->id, $response['data']->id);
    }

    /** @test */
    public function it_can_update_a_userbrt()
    {
        $userbrt = Userbrt::factory()->create(['user_id' => $this->user->id]);

        $data = [
            'reserved_amount' => 300.00,
            'status' => 'active',
        ];

        $this->userBrtService
            ->shouldReceive('updateUserbrt')
            ->with($this->user->id, $userbrt->id, $data)
            ->once()
            ->andReturn([
                'status' => true,
                'message' => 'User brt detail updated successfully',
            ]);

        $response = $this->userBrtService->updateUserbrt($this->user->id, $userbrt->id, $data);

        $this->assertTrue($response['status']);
        $this->assertEquals('User brt detail updated successfully', $response['message']);
    }

    /** @test */
    public function it_can_delete_a_userbrt()
    {
        $userbrt = Userbrt::factory()->create(['user_id' => $this->user->id]);

        $this->userBrtService
            ->shouldReceive('deleteUserbrt')
            ->with($this->user->id, $userbrt->id)
            ->once()
            ->andReturn([
                'status' => true,
                'message' => 'User brt detail deleted successfully',
            ]);

        $response = $this->userBrtService->deleteUserbrt($this->user->id, $userbrt->id);

        $this->assertTrue($response['status']);
        $this->assertEquals('User brt detail deleted successfully', $response['message']);
    }
}
