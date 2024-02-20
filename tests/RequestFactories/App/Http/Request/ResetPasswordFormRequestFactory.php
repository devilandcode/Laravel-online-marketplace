<?php

namespace Tests\RequestFactories\App\Http\Request;

use Illuminate\Support\Str;
use Worksome\RequestFactories\RequestFactory;

class ResetPasswordFormRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'token' => Str::random(10),
            'email' => $this->faker->email,
            'password' => $this->faker()->password(8),
        ];
    }
}
