<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Notifications\NewUserNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailNewUserListener
{
    public function handle(Registered $event): void
    {
        $event->user->notify(new NewUserNotification());
    }
}
