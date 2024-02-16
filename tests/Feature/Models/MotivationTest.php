<?php

namespace Tests\Feature\Models;

use App\Models\Motivation;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MotivationTest extends TestCase
{
    use DatabaseTransactions;

    public function testMotivationStore()
    {
        Sanctum::actingAs(User::factory()->create());

        $user = User::factory()->createOne();

        $this->json('POST', '/api/motivation/create', [
            'user_id' => $user->id,
            'description' => 'Hello World',
            'created_at' => Carbon::now()->format('d-m-Y')
        ])
        ->assertSuccessful();
    }

    public function testMotivationByUserId()
    {
        $user = Sanctum::actingAs(User::factory()->create());

        Motivation::factory()
        ->for($user)
        ->count(3)
        ->create();

        $this->json('GET', "/api/motivation/get-by-user-id")
        ->assertOk();
    }
}
