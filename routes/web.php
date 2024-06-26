<?php

use App\Http\Controllers\FOController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\TestController;
use App\Services\Settings\AuthHandler;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TravelRequestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

if (class_exists(AuthHandler::class))
    $login = app()->make('SystemService')->authorize()->global->login_route;

//Setting for SU idplogin
Route::get('/sulogin', 'SystemController@SUlogin')->name('sulogin');
Route::get($login, [SystemController::class, 'login'])->name('login');

//Language
Route::get('/lang/{lang}', [LocalizationController::class, 'index'])->name('language');
Route::statamic('search', 'search')->name('search');

//Travelrequest
Route::get('/travel', [TravelRequestController::class, 'create'])->name('travel-request-create');
Route::get('/{lang?}/travel', [TravelRequestController::class, 'create']);

Route::get('/travel/show/{id}', [TravelRequestController::class, 'show'])->name('travel-request-show');
Route::post('/travel', [TravelRequestController::class, 'submit'])->name('travel-submit');

Route::post('/travelresume/{tr}', [TravelRequestController::class, 'resume'])->name('travel-request-resume');

//ReviewHandler
Route::get('/travel/review/{id}', [\App\Http\Controllers\ReviewController::class, 'show'])->name('travel-request-review');
Route::post('/review/{id}', [\App\Http\Controllers\ReviewController::class, 'review'])->name('review');
Route::post('/fo_review/{id}', [\App\Http\Controllers\ReviewController::class, 'fo_review'])->name('fo_review');

//FO Handler
Route::get('/list', [FOController::class, 'list'])->name('request-list')->middleware('checklang');
Route::get('/{lang?}/list', [FOController::class, 'svlist'])->middleware('checklang');

Route::get('/show/{id}', [\App\Http\Controllers\FOController::class, 'show'])->name('fo-request-show');
Route::get('{lang?}/show/{id}', [\App\Http\Controllers\FOController::class, 'show']);
Route::get('/viewpdf/{id}', [\App\Http\Controllers\FOController::class, 'pdfview'])->name('travel-request-pdfview');
Route::get('/travel/pdf/{id}', [\App\Http\Controllers\FOController::class, 'download'])->name('travel-request-pdf');
Route::get('/settings', [\App\Http\Controllers\FOController::class, 'settings'])->name('settings');
Route::post('/fo', [\App\Http\Controllers\FOController::class, 'settings_fo'])->name('fo');

//News list entries
Route::get('/en/newslist/{collection}', [\App\Http\Controllers\NewsListController::class, 'list'])->name('list');
Route::get('/sv/newslist/{collection}', [\App\Http\Controllers\NewsListController::class, 'swelist'])->name('swelist');

//Test
Route::get('/test', [TestController::class, 'test'])->name('test');
Route::get('/s/{id}', [TestController::class, 'submit']);
Route::get('/ma/{id}', [TestController::class, 'manager_approve']);
Route::get('/mr/{id}', [TestController::class, 'manager_return']);

Route::get('/1', [TestController::class, 'testWorkflow'])->name('1');
Route::get('/2', [TestController::class, 'passTestWorkflow'])->name('2');
