<?php

// Only used to redirect password reset

Route::get('password-reset', function () {
    return redirect(config('ctic.spa_website'));
})->name('password.reset');

Route::namespace('\\App\\Modules\\Web\\')->group(function () {

    Route::get('/', 'HolaMundo@index');
    Route::get('/test', 'HolaMundo@test');
    Route::get('/valenti', 'SoyTonto@metode');

});
