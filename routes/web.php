<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/LuTsh9EniT4fCcOnntMHpWm7BxlIY8Ku/webhook', 'TelegramController@index');
