<?php

namespace Tests\Feature\App\Http\Controllers\Auth;


use App\Http\Controllers\AuthController;
use App\Http\Requests\SignUpFormRequest;
use App\Listeners\SendEmailNewUserListener;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_sign_up_success(): void
    {
        Event::fake();
        Notification::fake();


        $request = SignUpFormRequest::factory()->create([
            'email' => 'tom@tailor.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);

        $response = $this->post(action([AuthController::class, 'store']), $request);

        $response->assertRedirect();

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
}
