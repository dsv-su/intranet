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

//Vice settings
Route::get('/vice_settings', [\App\Http\Controllers\ViceController::class, 'settings'])->name('vice_settings');
Route::post('/settings/oh', [\App\Http\Controllers\ViceController::class, 'oh'])->name('oh_settings');
Route::post('/settings/form', [\App\Http\Controllers\ViceController::class, 'form'])->name('form_settings');

//Project Proposals
Route::get('/pp/{slug}', [\App\Http\Controllers\ProposalController::class, 'pp'])->name('pp');
Route::get('/pp/view/{id}', [\App\Http\Controllers\ReviewController::class, 'pp_view'])->name('pp-view');
Route::get('/new_pp', [\App\Http\Controllers\ProposalController::class, 'create'])->name('new-project');
Route::post('/submit_preapproval', [\App\Http\Controllers\ProposalController::class, 'submit'])->name('new-submit');
Route::get('/pp/review/{id}', [\App\Http\Controllers\ReviewController::class, 'pp_review'])->name('pp-review');
Route::post('/pp/decision', [\App\Http\Controllers\ProposalController::class, 'decision'])->name('pp-decision');
Route::get('/pp/complete/{id}', [\App\Http\Controllers\ProposalController::class, 'pp_complete'])->name('pp-complete');
Route::get('/pp/stage2_upload_pp/{id}', [\App\Http\Controllers\ProposalController::class, 'upload'])->name('pp-upload');
Route::get('/pp/stats/commited', [\App\Http\Controllers\StatsController::class, 'preapproved'])->name('pp-stats');
Route::get('/pp/stats/approved', [\App\Http\Controllers\StatsController::class, 'approved'])->name('pp-stats-approved');
Route::get('/pp/stats/recalc', [\App\Http\Controllers\StatsController::class, 'recalcBudget'])->name('pp-recalc');
Route::get('/pp/sent/{id}', [\App\Http\Controllers\ProposalController::class, 'pp_sent'])->name('pp-sent');
Route::get('/pp/granted/{id}', [\App\Http\Controllers\ProposalController::class, 'pp_granted'])->name('pp-granted');
Route::get('/pp/rejected/{id}', [\App\Http\Controllers\ProposalController::class, 'pp_rejected'])->name('pp-rejected');

//Resume
//Route::get('/pp/resume/{id}', [\App\Http\Controllers\ProjectProposalController::class, 'pp_resume'])->name('pp-resume');
Route::get('/pp/resume/{id}', [\App\Http\Controllers\ProposalController::class, 'pp_resume'])->name('pp-resume');

//Admin
Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'pp'])->name('pp-admin');
Route::get('/admin/del/{id}', [\App\Http\Controllers\AdminController::class, 'pp_delete'])->name('pp-delete');

//Test
Route::get('/test', [TestController::class, 'test'])->name('test');
Route::get('/seed', [\App\Http\Controllers\ViceController::class, 'seed'])->name('proposal-seeder');
Route::get('/reset', [\App\Http\Controllers\ViceController::class, 'reset'])->name('proposal-reset');
