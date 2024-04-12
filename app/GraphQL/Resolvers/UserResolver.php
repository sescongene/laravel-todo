<?php

namespace App\GraphQL\Resolvers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Type\Definition\ResolveInfo;

class UserResolver
{
    public function resolveMe($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): User
    {
        return Auth::user();
    }
}
