<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Tests\RequestFactories\App\Http\Request\ForgotPasswordFormRequestFactory;

class ForgotPasswordFormRequest extends FormRequest
{
    public static $factory = ForgotPasswordFormRequestFactory::class;
    public function authorize(): bool
    {
        return auth()->guest();
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email:dns'],
        ];
    }
}
