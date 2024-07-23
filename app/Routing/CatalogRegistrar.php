<?php

namespace App\Routing;

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\RouteRegistrar;
use App\Http\Controllers\CatalogController;
use Illuminate\Contracts\Routing\Registrar;
use App\Http\Middleware\CatalogViewMiddleware;

class CatalogRegistrar implements RouteRegistrar
{

    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function () {
            Route::get('/catalog/{category:slug?}', CatalogController::class)
                ->middleware([CatalogViewMiddleware::class])
                ->name('catalog');
        });
    }
}
