<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

final readonly class Login
{
    /** @param  array{}  $args */
    public function __invoke($_, array $args): array
    {
        $user = User::where('email', $args['email'])->first();
        if (!$user || !Hash::check($args['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return [
            'token' => $user->createToken(request()->header('user-agent'))->plainTextToken,
            'user' => $user
        ];
    }
}
