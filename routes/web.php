<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    logger()
        ->channel('telegram')
        ->debug('Hi');
    return view('welcome');
});
