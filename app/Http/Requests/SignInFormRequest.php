<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Tests\RequestFactories\App\Http\Request\SignInFormRequestFactory;

class SignInFormRequest extends FormRequest
{
    public static $factory = SignInFormRequestFactory::class;

    public function authorize(): bool
    {
        return auth()->guest();
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email:dns'],
            'password' => ['required'],
        ];
    }
}
