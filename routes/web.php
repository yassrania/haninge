<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ServiceFormController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Frontend routes
*/

// 🏠 Startsida
Route::get('/', [PageController::class, 'home'])->name('home');

// 💼 Tjänster
Route::get('/tjanster', [PageController::class, 'tjansterIndex'])->name('tjanster');
Route::get('/tjanster/{service:slug}', [PageController::class, 'tjansterShow'])->name('service.show');
Route::post('/tjanster/{service:slug}/form', [ServiceFormController::class, 'submit'])
    ->name('service.form.submit');

// 🕌 Sidor
Route::get('/bonetider', [PageController::class, 'bonetider'])->name('bonetider');
Route::get('/om-islam',  [PageController::class, 'omIslam'])->name('om-islam');
Route::get('/om-mosken', [PageController::class, 'omMosken'])->name('om-mosken');

// 📰 Nyheter
Route::get('/nyheter', [PageController::class, 'nyheter'])->name('nyheter');
Route::get('/nyheter/{nyhet:slug}', [PageController::class, 'nyheterShow'])->name('nyheter.show');


// 📞 Kontakt & Stöd
Route::get('/kontakt',     [PageController::class, 'kontakt'])->name('kontakt');
Route::get('/stod-mosken', [PageController::class, 'stodMosken'])->name('stod-mosken');
