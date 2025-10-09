<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ServiceFormController;

// Startsida
Route::get('/', [PageController::class, 'home'])->name('home');

// Tjänster
Route::get('/tjanster', [PageController::class, 'tjansterIndex'])->name('tjanster');
Route::get('/tjanster/{service:slug}', [PageController::class, 'tjansterShow'])->name('service.show');
Route::post('/tjanster/{service:slug}/form', [ServiceFormController::class, 'submit'])
    ->name('service.form.submit');
Route::get('/tjanster', [PageController::class, 'tjanster'])->name('tjanster');

// صفحات ثابتة (كلها من مجلد pages)
Route::get('/bonetider',    [PageController::class, 'bonetider'])->name('bonetider');
Route::get('/om-islam',     [PageController::class, 'omIslam'])->name('om-islam');
Route::get('/om-mosken',    [PageController::class, 'omMosken'])->name('om-mosken');
//Route::get('/nyheter',      [PageController::class, 'nyheter'])->name('nyheter');
Route::get('/nyheter', [PageController::class, 'nyheterIndex'])->name('nyheter.index');
Route::get('/nyheter/{nyhet:slug}', [PageController::class, 'nyheterShow'])->name('nyheter.show');
Route::get('/kontakt',      [PageController::class, 'kontakt'])->name('kontakt');
Route::get('/stod-mosken',  [PageController::class, 'stodMosken'])->name('stod-mosken');
