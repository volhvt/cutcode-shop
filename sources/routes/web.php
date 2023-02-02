<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return view('welcome');
});

Route::get('/debug-telegram-logger', static function (Request $request) {
    logger()
        ->channel('telegram')
        ->debug($request->get('message', 'WARNING : Not set Telegram log message!'));
});

Route::get('/debug-sentry', static function (Request $request) {
    throw new \RuntimeException($request->get('message', 'WARNING : Not set Sentry error message!'));
});
