<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ServiceFormController;
use App\Http\Controllers\PrayerPageController;
use App\Http\Controllers\NewsController;
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
Route::get('/bonetider', [PrayerPageController::class, 'index'])->name('bonetider');

Route::get('/om-islam',  [PageController::class, 'omIslam'])->name('om-islam');
Route::get('/om-mosken', [PageController::class, 'omMosken'])->name('om-mosken');

// 📰 Nyheter


Route::get('/nyheter', [NewsController::class, 'index'])->name('nyheter.index');   // لائحة الأخبار
Route::get('/nyheter/{slug}', [NewsController::class, 'show'])->name('nyheter.show'); // صفحة خبر



// 📞 Kontakt & Stöd
Route::get('/kontakt',     [PageController::class, 'kontakt'])->name('kontakt');
Route::post('/kontakt', [PageController::class, 'kontaktSubmit'])->name('kontakt.submit');

Route::get('/stod-mosken', [PageController::class, 'stodMosken'])->name('stod-mosken');
