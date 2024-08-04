<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;
use App\Models\User;
use App\Models\Userbrt;
use Illuminate\Support\Facades\Artisan;

class UserBrtControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Artisan::call('db:seed'); 
    }

    /** @test */
    public function it_can_list_all_userbrts()
    {
        Userbrt::factory()->count(3)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user);

        $response = $this->getJson('/api/brt');

        $response->assertStatus(Response::HTTP_OK)
                ->assertJson([
                    'status' => true,
                    'message' => 'User brt detail updated successfuly',
                ])
                ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'id',
                            'user_id',
                            'brt_code',
                            'reserved_amount',
                            'status',
                            'created_at',
                            'updated_at',
                        ]
                    ],
                    'message',
                    'status',
                ]);
    }

     /** @test */
     public function it_can_show_a_userbrt()
     {
         $userbrt = Userbrt::factory()->create(['user_id' => $this->user->id]);
 
         $this->actingAs($this->user);
 
         $response = $this->getJson("/api/brt/{$userbrt->id}");
 
         $response->assertStatus(Response::HTTP_OK)
                  ->assertJson([
                      'status' => true,
                      'message' => 'User brt detail updated successfuly',
                      'data' => [
                          'id' => $userbrt->id,
                          'user_id' => $this->user->id,
                      ],
                  ]);
     }

     /** @test */
    public function it_can_store_userbrt()
    {
        $data = [
            'reserved_amount' => 100,
        ];
        $this->actingAs($this->user);
        $response = $this->postJson('/api/brt/create', $data);
        $response->assertStatus(Response::HTTP_CREATED)
                ->assertJson([
                    'status' => true,
                    'message' => 'User brt detail updated successfuly',
                ]);

        $this->assertDatabaseHas('userbrts', [
            'user_id' => $this->user->id,
            'reserved_amount' => 100
        ]);
    }

    /** @test */
    public function it_can_update_userbrt()
    {
        $userbrt = Userbrt::factory()->create(['user_id' => $this->user->id]);

        $data = [
            'reserved_amount' => 300,
            'status' => 'active',
        ];

        $this->actingAs($this->user);

        $response = $this->putJson("/api/brt/{$userbrt->id}", $data);

        $response->assertStatus(Response::HTTP_OK)
                ->assertJson([
                    'status' => true,
                    'message' => 'User brt detail updated successfuly',
                ]);

        $this->assertDatabaseHas('userbrts', [
            'id' => $userbrt->id,
        ]);
    }


    /** @test */
    public function it_can_delete_a_userbrt()
    {
        $userbrt = Userbrt::factory()->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user);

        $response = $this->deleteJson("/api/brt/{$userbrt->id}");

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseMissing('userbrts', [
            'id' => $userbrt->id,
        ]);
    }
}
