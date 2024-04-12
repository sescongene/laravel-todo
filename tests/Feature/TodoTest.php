<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;
use App\Models\User;
use App\Models\Todo;

class TodoTest extends TestCase
{
    use MakesGraphQLRequests;
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        
        $this->be($user);
    }

    public function testTodoQuery()
    {
        $todo = Todo::factory()->create(['user_id' => auth()->id()]);

        $response = $this->graphQL('
            query {
                todo(id: ' . $todo->id . ') {
                    id
                    title
                    status
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'todo' => [
                    'id' => strval($todo->id),
                    'title' => $todo->title,
                    'status' => $todo->status,
                ],
            ],
        ]);
    }

    public function testTodosQuery()
    {
        $todos = Todo::factory()->count(3)->create(['user_id' => auth()->id()]);

        $response = $this->graphQL('
            query {
                todos {
                    data {
                        id
                        title
                        status
                    }
                }
            }
        ');

        $response->assertJsonCount(3, 'data.todos.data');
    }

    public function testCreateTodoMutation()
    {




        $response = $this->graphQL('
            mutation {
                createTodo(title: "Test Todo") {
                    id
                    title
                    status
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'createTodo' => [
                    'title' => 'Test Todo',
                    'status' => 'todo',
                ],
            ],
        ]);
    }


    public function testToggleTodoMutation()
    {

        $todo = Todo::factory()->create(['user_id' => auth()->id()]);



        $response = $this->graphQL('
            mutation {
                toggleTodo(id: ' . $todo->id . ') {
                    id
                    title
                    status
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'toggleTodo' => [
                    'id' => strval($todo->id),
                    'title' => $todo->title,
                    'status' => $todo->status === 'todo' ? 'completed' : 'todo',
                ],
            ],
        ]);
    }

    public function testDeleteTodoMutation()
    {

        $todo = Todo::factory()->create(['user_id' => auth()->id()]);



        $response = $this->graphQL('
            mutation {
                deleteTodo(id: ' . $todo->id . ') {
                    id
                    title
                    status
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'deleteTodo' => [
                    'id' => strval($todo->id),
                    'title' => $todo->title,
                    'status' => $todo->status,
                ],
            ],
        ]);

        $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
    }

    public function testDeleteDoneTodoMutation()
    {

        $doneTodo = Todo::factory()->create(['user_id' => auth()->id(), 'status' => 'completed']);
        $todo = Todo::factory()->create(['user_id' => auth()->id(), 'status' => 'todo']);



        $response = $this->graphQL('
            mutation {
                deleteDoneTodo {
                    id
                    title
                    status
                }
            }
        ');

        $response->assertJson([
            'data' => [
                'deleteDoneTodo' => [
                    [
                        'id' => strval($todo->id),
                        'title' => $todo->title,
                        'status' => $todo->status,
                    ],
                ],
            ],
        ]);

        $this->assertDatabaseMissing('todos', ['id' => $doneTodo->id]);
        $this->assertDatabaseHas('todos', ['id' => $todo->id]);
    }

    public function testDeleteAllTodoMutation()
    {

        $todos = Todo::factory()->count(3)->create(['user_id' => auth()->id()]);


        $response = $this->graphQL('
            mutation {
                deleteAllTodo
            }
        ');

        $response->assertJson([
            'data' => [
                'deleteAllTodo' => true,
            ],
        ]);

        foreach ($todos as $todo) {
            $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
        }
    }
}
