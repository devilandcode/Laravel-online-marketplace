<?php

namespace App\Contracts;

use Illuminate\Contracts\Routing\Registrar;

interface RouteRegisrar
{
    public function map(Registrar $registrar): void;
}
