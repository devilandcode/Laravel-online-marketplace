<?php

declare(strict_types=1);

namespace App\Routing;

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\RouteRegistrar;
use App\Http\Controllers\CartController;
use Illuminate\Contracts\Routing\Registrar;

final class CartRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function () {
            Route::controller(CartController::class)
                ->prefix('cart')
                ->group(function () {
                    Route::get('/', 'index')->name('cart');
                    Route::post('/{product}/add', 'add')->name('cart.add');
                    Route::post('/{item}/quantity', 'quantity')->name('cart.quantity');
                    Route::delete('/{item}/delete', 'delete')->name('cart.delete');
                    Route::delete('/truncate', 'truncate')->name('cart.truncate');
                });
        });
    }
}
