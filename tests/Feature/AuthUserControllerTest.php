<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;

class AuthUserControllerTest extends TestCase
{
    use RefreshDatabase;


    protected function setUp(): void
    {
        parent::setUp();

        if (app()->runningUnitTests()) {
            $clientRepo = app(ClientRepository::class);
            $clientRepo->createPersonalAccessClient(
                null,
                'Test Personal Access Client',
                'http://localhost'
            );
        }
    }

    /** @test */
    public function it_can_register_a_user()
    {
        $response = $this->postJson('/api/v1/auth/sign-up', [
            'name' => 'Mostafa',
            'email' => 'mostafa@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertCreated()
            ->assertJsonStructure([
                'status',
                'success',
                'data' => [
                    'user' => [
                        'id',
                        'name',
                        'email',
                    ],
                    'token',
                ],
            ]);
    }

    public function it_requires_valid_data_for_signup()
    {
        $response = $this->postJson('/api/v1/auth/sign-up', [
            'email' => 'invalid',
            'password' => '123',
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function it_can_login_a_user()
    {
        $user = User::create([
            'name' => 'Mostafa Asker',
            'email' => 'mostafa1@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/v1/auth/sign-in', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'status',
                'success',
                'data' => [
                    'user' => [
                        'id',
                        'name',
                        'email',
                    ],
                    'token',
                ],
            ]);
    }

    /** @test */
    public function it_rejects_invalid_credentials()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('correct_password'),
        ]);

        $response = $this->postJson('/api/v1/auth/sign-in', [
            'email' => 'test@example.com',
            'password' => 'wrong_password',
        ]);

        $response->assertStatus(403);
    }
}