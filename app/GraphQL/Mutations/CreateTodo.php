<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Todo;
use Illuminate\Support\Facades\Log;

final readonly class CreateTodo
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        Log::info(11);
        Log::info( auth()->id());
        $data = [
            'title' => $args['title'],
            'status' => $args['status'],
            'user_id' => auth()->id()
        ];

        $todo = Todo::create($data);

        return $todo;
    }
}
