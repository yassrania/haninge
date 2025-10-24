<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\PageController;
use App\Http\Controllers\ServiceFormController;
use App\Http\Controllers\PrayerPageController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\MembershipApplicationController;

/*
|--------------------------------------------------------------------------
| Frontend
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [PageController::class, 'home'])->name('home');

// Services

Route::get('/tjanster', [PageController::class, 'tjansterIndex'])->name('tjanster');
Route::get('/tjanster/{slug}', [PageController::class, 'tjansterShow'])->name('service.show');


Route::post('/tjanster/{service:slug}/form', [ServiceFormController::class, 'submit'])->name('service.form.submit');

// Pages
Route::get('/bonetider', [PrayerPageController::class, 'index'])->name('bonetider');
Route::get('/om-islam',  [PageController::class, 'omIslam'])->name('om-islam');
Route::get('/om-mosken', [PageController::class, 'omMosken'])->name('om-mosken');

// News
Route::get('/nyheter', [NewsController::class, 'index'])->name('nyheter.index');
Route::get('/nyheter/{slug}', [NewsController::class, 'show'])->name('nyheter.show');

// Contact & Support
Route::get('/kontakt', [PageController::class, 'kontakt'])->name('kontakt');
Route::post('/kontakt', [PageController::class, 'kontaktSubmit'])->name('kontakt.submit');
Route::get('/stod-mosken', [PageController::class, 'stodMosken'])->name('stod-mosken');

// Membership (form + submit)
Route::get('/medlemskap',  [MembershipApplicationController::class, 'create'])->name('membership.create');
Route::post('/medlemskap', [MembershipApplicationController::class, 'store'])->name('membership.store');

/*
|--------------------------------------------------------------------------
| Auth alias for Filament
|--------------------------------------------------------------------------
| Provides route('login') and sends users to your Filament panel.
| Change '/admin' below if your panel path is different.
*/
Route::get('/login', fn () => redirect('/admin'))->name('login');

/*
|--------------------------------------------------------------------------
| Public PDF route (outside /admin to avoid Filament redirects)
|--------------------------------------------------------------------------
| The Filament table action should link to:
|   route('membership.pdf.public', ['id' => $record->getKey()])
*/
Route::get('/print/membership-applications/{id}', [MembershipApplicationController::class, 'adminPdfById'])
    ->name('membership.pdf.public');
// ->middleware('auth') // optional: add auth if you want protection

/*
|--------------------------------------------------------------------------
| OTP
|--------------------------------------------------------------------------
*/
Route::post('/membership/send-otp', [MembershipApplicationController::class, 'sendOtp'])
    ->name('membership.send-otp')
    ->middleware('throttle:6,1'); // limit: 6 requests per minute
/*
|--------------------------------------------------------------------------
| Arkiv
|--------------------------------------------------------------------------
*/

   

Route::get('/arkiv', [PageController::class, 'arkivIndex'])->name('arkiv.index');
Route::get('/arkiv/{archive:slug}', [PageController::class, 'arkivShow'])->name('arkiv.show');
