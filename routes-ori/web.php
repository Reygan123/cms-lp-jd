<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dukungan;
use App\Models\Welcomechat;
use Illuminate\Support\Facades\Route;


Route::get('/salaam', function () {
    return view('auth.login');
});
// Route::middleware('document')->group(function () {

Route::get('/', [\App\Http\Controllers\HomeController::class,'index']) ->name('home');
Route::resource('/post', \App\Http\Controllers\FpostController::class,['as' => 'post']);
Route::resource('/agenda', \App\Http\Controllers\FagendaController::class,['as' => 'agenda']);
Route::resource('/contact', \App\Http\Controllers\FcontactController::class,['as' => 'front']);
Route::get('/testimony', [\App\Http\Controllers\FtestimonyController::class,'index']) ->name('testimony');
Route::get('/prosedur', [\App\Http\Controllers\ProsedurController::class, 'index'])->name('prosedur');
Route::get('/maps',[\App\Http\Controllers\MapsController::class, 'index'])->name('maps');
Route::get('/investasi',[\App\Http\Controllers\InvestasiController::class, 'index'])->name('investasi');
Route::resource('/about-us',  \App\Http\Controllers\AboutController::class,['as' => 'front']);
Route::resource('/ourteam',  \App\Http\Controllers\OurteamController::class,['as' => 'front']);
Route::resource('/benefit',  \App\Http\Controllers\FbenefitController::class,['as' => 'front']);
Route::resource('/member', \App\Http\Controllers\MemberController::class, ['as' => 'front']);
Route::resource('/unggulan', \App\Http\Controllers\FunggulanController::class, ['as' => 'front']);
Route::resource('/sejarah', \App\Http\Controllers\FsejarahController::class, ['as' => 'front']);
Route::resource('/our-legal', \App\Http\Controllers\FlegalController::class, ['as' => 'front']);
Route::resource('/program', \App\Http\Controllers\FprogramController::class, ['as' => 'front']);
Route::resource('/assessment', \App\Http\Controllers\FfacilityController::class, ['as' => 'front']);
Route::resource('/portofolio', \App\Http\Controllers\PortofolioController::class, ['as' => 'front']);
Route::get('/investasi', [\App\Http\Controllers\InvestasiController::class, 'index'])->name('investasi');
Route::get('/karir',[\App\Http\Controllers\KarirController::class,'index'])->name('karir');
Route::get('/faq', [\App\Http\Controllers\FaqController::class, 'index'])->name('faq');
// });


/**
 * route for admin
 */

//group route with prefix "admin"
Route::prefix('admin')->group(function () {

    //group route with middleware "auth"
    Route::group(['middleware' => 'auth'], function() {

        // Setting
        //route user profile
        Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile.index');
        Route::post('/profile/store', [ProfileController::class, 'store'])->name('admin.profile.store');
        Route::put('/profile/update/{user}', [ProfileController::class, 'update'])->name('admin.profile.update');

        //route dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');
        
        //route resource slider
        Route::resource('/slider', SliderController::class, ['as' => 'admin']);


        //route resource headers
        Route::resource('/header', HeaderController::class, ['as' => 'admin']);

        //route user profile
        Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile.index');

        // //route resource identity
        Route::resource('/identity', IdentityController::class,['as' => 'admin']);

        //route resource banner
        Route::resource('/sidebanner', SidebannerController::class,['as' => 'admin']);

        //Profil
        
        //route resource sambutan
        Route::resource('/sambutan', SambutanController::class,['as' => 'admin']);

        //route resource about
        Route::resource('/about', AboutController::class,['as' => 'admin']);

         //route resource about
         Route::resource('/videoprofile', VideoprofileController::class,['as' => 'admin']);
        
         //route resource visi
         Route::resource('/visi', VisiController::class,['as' => 'admin']);
 
         //route resource misi
         Route::resource('/misi', MisiController::class,['as' => 'admin']);

        //route resource alasan
        Route::resource('/unggulan', UnggulanController::class,['as' => 'admin']);
        Route::delete('admin/unggulan/massDestroy', [UnggulanController::class, 'massDestroy'])->name('admin.unggulan.massDestroy');

        //route resource pricing
        Route::resource('/pricing', PricingController::class,['as' => 'admin']);
        Route::delete('admin/pricing/massDestroy', [PricingController::class, 'massDestroy'])->name('admin.pricing.massDestroy');

        //route resource categoriprestasi
        Route::resource('/categoriprestasi', CategoriprestasiController::class,['as' => 'admin']);

        //route resource prestasi
        Route::resource('/prestasi', PrestasiController::class, ['as' => 'admin']);
        Route::delete('admin/prestasi/massDestroy', [PrestasiController::class, 'massDestroy'])->name('admin.prestasi.massDestroy');

        //route resource Fasilitas
        Route::resource('/facility', FacilityController::class, ['as' => 'admin']);
        Route::delete('admin/facility/massDestroy', [FacilityController::class, 'massDestroy'])->name('admin.facility.massDestroy');

        //route resource Dukungans
        Route::resource('/dukungan', DukunganController::class, ['as' => 'admin']);
        Route::delete('admin/dukungan/massDestroy', [DukunganController::class, 'massDestroy'])->name('admin.dukungan.massDestroy');



        //route resource Testimony
        Route::resource('/testimony', TestimonyController::class, ['as' => 'admin']);
        Route::resource('/judul', JudulController::class, ['as' => 'admin']);

        //route resource Data
        Route::resource('/svg', SvgController::class, ['as' => 'admin']);

        //route resource program
        Route::resource('/program', ProgramController::class, ['as' => 'admin']);

        Route::prefix('program')->group(function () {
            Route::get('/create/halaman-pertama', [ProgramController::class, 'getHalamanPertama'])->name('admin.program.create.halaman-pertama');
            Route::post('/create/halaman-pertama', [ProgramController::class, 'postHalamanPertama']);

            Route::get('/create/halaman-kedua', [ProgramController::class, 'getHalamanKedua'])->name('admin.program.create.halaman-kedua');
            Route::post('/create/halaman-kedua', [ProgramController::class, 'postHalamanKedua']);

            Route::get('/create/halaman-ketiga', [ProgramController::class, 'getHalamanKetiga'])->name('admin.program.create.halaman-ketiga');
            Route::post('/create/halaman-ketiga', [ProgramController::class, 'postHalamanKetiga']);

            Route::get('/{program}/edit/halaman-pertama', [ProgramController::class, 'editHalamanPertama'])->name('admin.program.edit.halaman-pertama');
            Route::put('/{program}/edit/halaman-pertama', [ProgramController::class, 'updateHalamanPertama']);

            Route::get('/{program}/edit/halaman-kedua', [ProgramController::class, 'editHalamanKedua'])->name('admin.program.edit.halaman-kedua');
            Route::put('/{program}/edit/halaman-kedua', [ProgramController::class, 'updateHalamanKedua']);

            Route::get('/{program}/edit/halaman-ketiga', [ProgramController::class, 'editHalamanKetiga'])->name('admin.program.edit.halaman-ketiga');
            Route::put('/{program}/edit/halaman-ketiga', [ProgramController::class, 'updateHalamanKetiga']);
        });
        Route::delete('admin/program/massDestroy', [ProgramController::class, 'massDestroy'])->name('admin.program.massDestroy');
        Route::delete('/admin/programs/{program}/deleteImage/{image}', [ProgramController::class, 'deleteImage'])->name('admin.programs.deleteImage');


        //route resource Ourteam
        Route::resource('/ourteam', OurteamController::class, ['as' => 'admin']);
        Route::resource('/ourteamopening', OurteamopeningController::class, ['as' => 'admin']);


        //route resource seragam
        Route::resource('/seragam', SeragamController::class,['as' => 'admin']);

        //Publikasi

        //route resource agenda
        Route::resource('/agenda', AgendaController::class,['as' => 'admin']);
        Route::delete('admin/agenda/massDestroy', [AgendaController::class, 'massDestroy'])->name('admin.agenda.massDestroy');


        //route resource categories
        Route::resource('/category', CategoryController::class,['as' => 'admin']);

        //route resource post
        Route::resource('/post', PostController::class, ['as' => 'admin']);
        Route::delete('admin/post/massDestroy', [PostController::class, 'massDestroy'])->name('admin.post.massDestroy');


        //Landing Page
        Route::resource('/infodaftar', InfodaftarController::class, ['as' => 'admin']);
    
        //route resource contact
        // Route::resource('/contact', ContactController::class, ['as' => 'admin']);

        //route resource benefit
        Route::resource('/benefit', BenefitController::class, ['as' => 'admin']);
        Route::get('/admin/titlebenefit/{titlebenefit}/delete-image/{image}', [TitlebenefitController::class, 'deleteImage'])->name('admin.titlebenefit.deleteImage');
        Route::resource('/titlebenefit', TitlebenefitController::class, ['as' => 'admin']);


        //route resource story
        Route::resource('/story', StoryController::class, ['as' => 'admin']);

        //route resource opening
        // Route::resource('/openingstory', OpeningstoryController::class, ['as' => 'admin']);

        //route resource partnership
        Route::resource('/partner', PartnerController::class, ['as' => 'admin']);

        //route resource social
        Route::resource('/social', SocialController::class, ['as' => 'admin']);

        //route resource impact
        Route::resource('/impact', ImpactController::class, ['as' => 'admin']);

        //route resource impact
        Route::resource('/catatan', CatatanController::class, ['as' => 'admin']);

        

        // //route resource Renstra
        // Route::resource('/renstra', RenstraController::class, ['as' => 'admin']);

        //route resource Lulusan
        // Route::resource('/lulusan', LulusanController::class, ['as' => 'admin']);

        //route resource Legalitas
        Route::resource('/legal', LegalController::class, ['as' => 'admin']);

        //route resource Yutub
        // Route::resource('/yutub', YutubController::class, ['as' => 'admin']);


        //route resource FAQ
        Route::resource('/faq', FaqController::class, ['as' => 'admin']);
        Route::delete('admin/faq/massDestroy', [FaqController::class, 'massDestroy'])->name('admin.faq.massDestroy');



        //route resource Alumni 
        Route::resource('/alumni', AlumniController::class, ['as' => 'admin']);
        Route::delete('admin/alumni/massDestroy', [AlumniController::class, 'massDestroy'])->name('admin.alumni.massDestroy');



        //route resource Gambaran
        // Route::resource('/gambaran', GambaranController::class,['as' => 'admin']);

        //route resource portofolio
        Route::resource('/portofolio', PortofolioController::class, ['as' => 'admin']);
        Route::get('/admin/portofolio/{portofolio}/delete-image/{image}', [PortofolioController::class, 'deleteImage'])->name('admin.portofolio.deleteImage');
        Route::delete('admin/portofolio/massDestroy', [PortofolioController::class, 'massDestroy'])->name('admin.portofolio.massDestroy');

        //route resource kegiatan osis
        Route::resource('/osis', KegiatanOsisController::class,['as' => 'admin']);


        //route resource kegiatan ekstrakurikuler
        Route::resource('/ekskul', EkskulController::class,['as' => 'admin']);

        //route resource prosedur
        Route::resource('/prosedur', ProsedurController::class,['as' => 'admin']);

        //route resource tanggal penting
        Route::resource('/tanggalpenting', TanggalpentingController::class,['as' => 'admin']);
        Route::delete('admin/tanggalpenting/massDestroy', [TanggalpentingController::class, 'massDestroy'])->name('admin.tanggalpenting.massDestroy');


        //route resource tanggal penting
        // Route::resource('/typedaftar', TypedaftarController::class,['as' => 'admin']);

        //route resource Link daftar
        Route::resource('/linkdaftar', LinkdaftarController::class,['as' => 'admin']);

        Route::resource('/welcomechat', WelcomechatController::class,['as' => 'admin']);
        Route::resource('/pixel', PixelController::class, ['as' => 'admin']);
        Route::resource('/ganalytics', GanalyticsController::class, ['as' => 'admin']);
    });
});