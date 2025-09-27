<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

// Startsida
Route::get('/', [PageController::class, 'home'])->name('home');

// Tjänster (لائحة عامة/صفحة تجميع)
Route::get('/tjanster', [PageController::class, 'tjansterIndex'])->name('tjanster');

// صفحة خدمة مفردة
Route::get('/tjanster/{service:slug}', [PageController::class, 'tjansterShow'])->name('service.show');

// باقي الصفحات ديالك...
Route::get('/bonetider',  [PageController::class, 'bonetider'])->name('bonetider');
Route::get('/om-islam',   [PageController::class, 'omIslam'])->name('om-islam');
Route::get('/om-mosken',  [PageController::class, 'omMosken'])->name('om-mosken');
Route::get('/nyheter',    [PageController::class, 'nyheter'])->name('nyheter');
Route::get('/kontakt',    [PageController::class, 'kontakt'])->name('kontakt');
Route::get('/stod-mosken',[PageController::class, 'stodMosken'])->name('stod-mosken');
