<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\User;

final readonly class Register
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        $user = User::create($args);

        $token = $user->createToken('authToken')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
