<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;

class AuthTest extends TestCase
{
    use MakesGraphQLRequests;
    use RefreshDatabase;

    public function testLoginMutation()
    {
        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->graphQL('
            mutation {
                login(email: "test@test.com", password: "password") {
                    user {
                        id
                        email
                    }
                    token
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'login' => [
                    'user' => [
                        'id' => $user->id,
                        'email' => 'test@test.com',
                    ],
                    'token' => true,
                ],
            ],
        ]);
    }

    public function testMeQuery()
    {
        $user = User::factory()->create();

        $this->be($user);

        $response = $this->graphQL('
            query {
                me {
                    id
                    email
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'me' => [
                    'id' => $user->id,
                    'email' => $user->email,
                ],
            ],
        ]);
    }
}
