<?php

namespace App\GraphQL\Resolvers;

use App\Enums\TodoStatus;
use App\Models\Todo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Type\Definition\ResolveInfo;

class TodoResolver
{
    public function resolveToggleTodo($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): Todo
    {
        $todo = Todo::findOrFail($args['id']);
        $todo->status = $todo->status == TodoStatus::COMPLETED ? TodoStatus::TODO : TodoStatus::COMPLETED;
        $todo->save();

        return $todo;
    }


    public function resolveDeleteDone($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        /** @var App\Models\User $user */
        $user = auth()->user();

        $user->todos()->where('status', TodoStatus::COMPLETED)->delete();

        return $user->todos;
    }

    public function resolveDeleteAll($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        /** @var App\Models\User $user */
        $user = auth()->user();

        $user->todos()->delete();

        return $user->todos;
    }
}
