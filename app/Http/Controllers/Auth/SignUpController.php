<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Foundation\Application as App;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SignUpController extends Controller
{
    public function page(): View|Application|Factory|App
    {
        return view('auth.sign-up');
    }

    public function handle(SignUpFormRequest $request, RegisterNewUserContract $action): RedirectResponse
    {
        // TODO make DTOs

        try {
            $action(
                $request['name'],
                $request['email'],
                $request['password']
            );
        } catch(\Illuminate\Database\QueryException $e) {
            logger()
                ->channel('telegram')
                ->debug('Create User Error: ' . request()->url());

            return redirect()->back()->with('error', 'Create user error');
        }

        $request->session()->regenerate();

        return redirect()
            ->intended(route('home'));
    }
}
