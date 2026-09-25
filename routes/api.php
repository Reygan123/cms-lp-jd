<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PelatihanAPIController;

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

// Service routes
Route::get('/service', [APIController::class, 'getServiceAll'])->name('getServiceAll');
Route::get('/service/{slug}', [APIController::class, 'getServiceSlug'])->name('getServiceSlug');

// WhyService routes
Route::get('/why-service', [APIController::class, 'getWhyServiceAll'])->name('getWhyServiceAll');
Route::get('/why-service/by-service-slug/{service_slug}', [APIController::class, 'getWhyServiceByServiceSlug'])->name('getWhyServiceByServiceSlug');

// Alasan routes
Route::get('/alasan-service', [APIController::class, 'getAlasanServiceAll'])->name('getAlasanServiceAll');
Route::get('/alasan-service/by-service-slug/{service_slug}', [APIController::class, 'getAlasanServiceByServiceSlug'])->name('getAlasanServiceByServiceSlug');

// How routes
Route::get('/how-service', [APIController::class, 'getHowServiceAll']);
Route::get('/how-service/by-service-slug/{service_slug}', [APIController::class, 'getHowServiceByServiceSlug']);

// Bonus routes
Route::get('/bonus-service', [APIController::class, 'getBonusServiceAll']);
Route::get('/bonus-service/by-service-slug/{service_slug}', [APIController::class, 'getBonusServiceByServiceSlug']);

// MasalahService routes
Route::get('/masalah-service', [APIController::class, 'getMasalahServiceAll']);
Route::get('/masalah-service/by-service-slug/{service_slug}', [APIController::class, 'getMasalahServiceByServiceSlug']);

// Activity routes
Route::get('/activity', [APIController::class, 'getActivityAll']);
Route::get('/activity/by-service-slug/{service_slug}', [APIController::class, 'getActivityByServiceSlug']);

// ManfaatService routes
Route::get('/manfaat-service', [APIController::class, 'getManfaatServiceAll']);
Route::get('/manfaat-service/by-service-slug/{service_slug}', [APIController::class, 'getManfaatServiceByServiceSlug']);

// Statistik routes
Route::get('/statistik', [APIController::class, 'getStatistikAll']);

// FAQ routes
Route::get('/faq', [APIController::class, 'getFaqAll']);
Route::get('/faq/by-category/{category}', [APIController::class, 'getFaqByCategory']);

// USP routes
Route::get('/usp', [APIController::class, 'getUspAll'])->name('getUspAll');

// Pelatihan (Training Registration) routes
Route::get('/pelatihan', [PelatihanAPIController::class, 'index'])->name('pelatihan.index');
Route::get('/pelatihan/{slug}', [PelatihanAPIController::class, 'show'])->name('pelatihan.show');
Route::post('/pelatihan/check-referral', [PelatihanAPIController::class, 'checkReferral'])->name('pelatihan.check-referral');
Route::post('/pelatihan/daftar', [PelatihanAPIController::class, 'register'])->name('pelatihan.register');
Route::get('/pelatihan/cek-status/{code}', [PelatihanAPIController::class, 'checkStatus'])->name('pelatihan.check-status');
