<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Tests\RequestFactories\App\Http\Request\ResetPasswordFormRequestFactory;

class ResetPasswordFormRequest extends FormRequest
{
    public static $factory = ResetPasswordFormRequestFactory::class;
    public function authorize(): bool
    {
        return auth()->guest();
    }

    public function rules(): array
    {
        return [
            'token' => 'required',
            'email' => ['required', 'email:dns'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }
}
