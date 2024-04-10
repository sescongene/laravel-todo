<?php

namespace App\GraphQL\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TodoBuilder
{
    public function byUser(Builder $builder): Builder
    {
        return $builder->where('user_id', Auth::id());
    }
}
