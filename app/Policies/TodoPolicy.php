<?php

namespace App\Policies;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

class TodoPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Todo $todo): bool
    {
        return $todo ? $user->id === $todo->user_id : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Todo $todo)
    {
        return $user->id === $todo->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Todo $todo): bool
    {
        return $user->id === $todo->user_id;
    }

    public function resolve($root, $args, $context, $info)
    {
        $todo = Todo::find($args['id']);

        if (Gate::denies('view', $todo)) {
            throw new AuthorizationException('You do not have permission to view this todo.');
        }

        return $todo;
    }
}
