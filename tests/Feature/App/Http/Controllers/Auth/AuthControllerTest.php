<?php

namespace Tests\Feature\App\Http\Controllers\Auth;


use App\Http\Controllers\AuthController;
use App\Http\Requests\ForgotPasswordFormRequest;
use App\Http\Requests\ResetPasswordFormRequest;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use App\Listeners\SendEmailNewUserListener;
use App\Notifications\NewUserNotification;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_login_page_success()
    {
        $this->get(action([AuthController::class, 'index']))
            ->assertOk()
            ->assertSee('Log into account')
            ->assertViewIs('auth.login');
    }

    /**
     * @test
     */
    public function it_sign_ap_page_success()
    {
        $this->get(action([AuthController::class, 'signUp']))
            ->assertOk()
            ->assertSee('Register')
            ->assertViewIs('auth.sign-up');
    }

    /**
     * @test
     */
    public function it_forgot_page_success()
    {
        $this->get(action([AuthController::class, 'forgot']))
            ->assertOk()
            ->assertSee('Forgot password')
            ->assertViewIs('auth.forgot-password');
    }

    /**
     * @test
     */
    public function it_sign_in_success()
    {
        $password = '12345678';
        $user = User::factory()->create([
            'email' => 'testing@gmail.com',
            'password' => bcrypt($password),
        ]);

        $request = SignInFormRequest::factory()->create([
           'email' => $user->email,
           'password' =>  $password,
        ]);

        $response = $this->post(action([AuthController::class, 'signIn']), $request);

        $response->assertValid()
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }

    /**
     * @test
     */
    public function it_logout_success(): void
    {
        $user = User::factory()->create([
            'email' => 'testing@gmail.com',
        ]);

        $this->actingAs($user)
            ->delete(action([AuthController::class, 'logOut']));

        $this->assertGuest();
    }

    /**
     * @test
     */
    public function it_sign_up_success(): void
    {
        Event::fake();
        Notification::fake();

        $request = SignUpFormRequest::factory()->create([
            'email' => 'testing@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => $request['email']
        ]);

        $response = $this->post(action([AuthController::class, 'store']), $request);


        $this->assertDatabaseHas('users', [
            'email' => $request['email']
        ]);

        /* @var Authenticatable $user */
        $user = User::query()->where(['email' => $request['email']])->first();

        Event::assertDispatched(Registered::class);
        Event::assertListening(Registered::class, SendEmailNewUserListener::class);

        $event = new Registered($user);
        $listener = new SendEmailNewUserListener();
        $listener->handle($event);

        Notification::assertSentTo($user, NewUserNotification::class);

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect(route('home'));
    }

    /**
     * @test
     */
    public function it_forgot_password_success(): void
    {
        $user = User::factory()->create([
            'email' => 'testing@gmail.com',
        ]);

        $this->assertGuest();

        $request = ForgotPasswordFormRequest::factory()->create([
            'email' => $user->email,
        ]);

        $response = $this->post(action([AuthController::class, 'forgotPassword']), $request);

        $response->assertSessionHas('market_flash_message', "We have emailed your password reset link.")
            ->assertRedirect();

    }

    /**
     * @test
     */
    public function it_reset_page_success(): void
    {
        $token = Str::random();

        $this->get(action([AuthController::class, 'reset'], ['token' => $token]))
           ->assertOk()
           ->assertViewIs('auth.reset-password')
           ->assertSee($token);
    }

    /**
     * @test
     */
    public function it_password_reset_success(): void
    {
        Event::fake();

        $password = '12345678';
        $user = User::factory()->create([
            'email' => 'testing@gmail.com',
            'password' => bcrypt(Str::random(8)),
        ]);

        $request = ResetPasswordFormRequest::factory()->create([
            'token' => Password::createToken($user),
            'email' => 'testing@gmail.com',
            'password' =>  $password,
            'password_confirmation' => $password,
        ]);

        $response = $this->post(action([AuthController::class, 'resetPassword']), $request);

        Event::assertDispatched(PasswordReset::class);

        $response->assertSessionHas('market_flash_message', 'Your password has been reset.')
            ->assertRedirect();

    }
}
