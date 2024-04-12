<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;
use App\Models\User;

class UserTest extends TestCase
{
    use MakesGraphQLRequests;
    use RefreshDatabase;

    // authenticate user
    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->be($user);
    }

    public function testUserQuery()
    {
        $user = User::factory()->create();


        $response = $this->graphQL('
            query {
                user(id: ' . $user->id . ') {
                    id
                    name
                    email
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'user' => [
                    'id' => strval($user->id),
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ],
        ]);
    }

    public function testUsersQuery()
    {
        $users = User::factory()->count(3)->create();

        $response = $this->graphQL('
            query {
                users {
                    data {
                        id
                        name
                        email
                    }
                }
            }
        ');
        // Add 1 for setup
        $response->assertJsonCount(4, 'data.users.data');
    }
}
