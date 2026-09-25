<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Post
Route::get('/post', [APIController::class, 'index'])->name('post');
Route::get('/post/{slug}', [APIController::class, 'show'])->name('post');

// agenda
Route::get('/agenda', [APIController::class, 'getAgendaAll'])->name('getAgendaAll');
Route::get('/agenda/{slug}', [APIController::class, 'getAgendaSlug'])->name('getAgendaSlug');

// program
Route::get('/program', [APIController::class, 'getProgramAll'])->name('getProgramAll');
Route::get('/program/{slug}', [APIController::class, 'getProgramSlug'])->name('getProgramSlug');

// unggulan
Route::get('/unggulan', [APIController::class, 'getUnggulanAll'])->name('getUnggulanAll');
Route::get('/unggulan/{slug}', [APIController::class, 'getUnggulanSlug'])->name('getUnggulanSlug');

// assesment
Route::get('/assesment', [APIController::class, 'getAssesmentAll'])->name('getAssesmentAll');
Route::get('/assesment/{slug}', [APIController::class, 'getAssesmentSlug'])->name('getAssesmentSlug');

// pricing
Route::get('/pricing', [APIController::class, 'getPricingAll'])->name('getPricingAll');
Route::get('/pricing/{slug}', [APIController::class, 'getPrcingSlug'])->name('getPrcingSlug');

// benefit
Route::get('/benefit', [APIController::class, 'getBenefitAll'])->name('getBenefitAll');
Route::get('/benefit/{slug}', [APIController::class, 'getBenefitSlug'])->name('getBenefitSlug');
Route::get('/benefit-assesment/{id}', [APIController::class, 'getBenefitByAssesment'])->name('getBenefitByAssesment');

// testimoni
Route::get('/testimoni', [APIController::class, 'getTestimoniAll'])->name('getTestimoniAll');
Route::get('/testimoni/{slug}', [APIController::class, 'getTestimoniSlug'])->name('getTestimoniSlug');

// portofolio
Route::get('/portofolio', [APIController::class, 'getPortofolioAll'])->name('getPortofolioAll');
Route::get('/portofolio/{slug}', [APIController::class, 'getPortofolioSlug'])->name('getPortofolioSlug');

// portofolio
Route::get('/support', [APIController::class, 'getSupportAll'])->name('getSupportAll');
Route::get('/support/{slug}', [APIController::class, 'getSupportSlug'])->name('getSupportSlug');

// partner
Route::get('/partner', [APIController::class, 'getPartnerAll'])->name('getPartnerAll');
Route::get('/partner/{slug}', [APIController::class, 'getPartnerSlug'])->name('getPartnerSlug');

// Legal Document
Route::get('/legal', [APIController::class, 'getLegalAll'])->name('getLegalAll');
Route::get('/legal/{id}', [APIController::class, 'getLegalId'])->name('getLegalId');

// our team
Route::get('/team', [APIController::class, 'getTeamAll'])->name('getTeamAll');
Route::get('/team/{id}', [APIController::class, 'getTeamId'])->name('getTeamId');

// slider
Route::get('/slider', [APIController::class, 'getSliderAll'])->name('getSliderAll');

// SEO
Route::get('/meta-pixel', [APIController::class, 'indexPixel'])->name('meta-fixel');
Route::get('/google-analytics', [APIController::class, 'indexAnalytics'])->name('google-analytics');
Route::get('/chat', [APIController::class, 'indexChat'])->name('chats');

Route::get('/identity', [APIController::class, 'identitiy'])->name('identitiy');