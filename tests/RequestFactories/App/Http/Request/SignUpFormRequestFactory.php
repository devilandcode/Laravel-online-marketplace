<?php

namespace Tests\RequestFactories\App\Http\Request;

use Worksome\RequestFactories\RequestFactory;

class SignUpFormRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->email,
            'password' => $this->faker()->password(8),
        ];
    }
}
