<?php

namespace Tests\RequestFactories\App\Http\Request;

use Worksome\RequestFactories\RequestFactory;

class ForgotPasswordFormRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'email' => $this->faker->email,
        ];
    }
}
