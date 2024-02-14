<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testRegister()
    {
        $this->json('POST', '/api/register', [
            'name' => 'Test',
            'profesi' => 'Mahasiswa',
            'email' => 'mahasiswa@admin.com',
            'password' => Hash::make('password')
        ])
        ->assertSuccessful();
    }

    public function testLogin()
    {
        $user = User::factory()->create();

        $this->json('POST', '/api/login', [
            'email' => $user->email,
            'password' => 'password'
        ])
        ->assertSuccessful();
    }

    public function testGetUser()
    {
        Sanctum::actingAs(User::factory()->create());

        User::factory()->count(5)->create();

        $this->json('POST', '/api/get-user')
        ->assertSuccessful();
    }

    public function testLogout()
    {
        Sanctum::actingAs(User::factory()->create());

        $this->json('POST', '/api/logout')
        ->assertSuccessful();
    }
}
