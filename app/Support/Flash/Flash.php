<?php

declare(strict_types=1);

namespace App\Support\Flash;

use Illuminate\Contracts\Session\Session;

class Flash
{
    public function __construct(protected Session $session)
    {
    }

    public function get():FlashMessage
    {

    }
    public function info()
    {

    }

    public function alert()
    {

    }

}
