<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services. 
     *
     * @return void
     */
    public function boot()
    {
        $identities = DB::table('identities')->get();
        View::share('identities', $identities);

        $visis = DB::table('visis')->get();
        View::share('visis', $visis);

        $visis = DB::table('abouts')->get();
        View::share('abouts', $visis);

        $sidebanners = DB::table('sidebanners')->get();
        View::share('sidebanners', $sidebanners);

        $infodaftars = DB::table('infodaftars')->get();
        View::share('infodaftars', $infodaftars);

        $linkdaftars = DB::table('linkdaftars')->get();
        View::share('linkdaftars', $linkdaftars);

        $programs = DB::table('programs')->get();
        View::share('programs', $programs);

        $facilities = DB::table('facilities')->get();
        View::share('facilities', $facilities);

        $oprograms = DB::table('programs')->where('id', '>', 0)->whereRaw('id % 2 != 0')->get();
        View::share('oprograms', $oprograms);

        $eprograms = DB::table('programs')->where('id', '>', 0)->whereRaw('id % 2 = 0')->get();
        View::share('eprograms', $eprograms);

        $iprograms = DB::table('programs')->where('id', '=', '2')->get();
        View::share('iprograms', $iprograms);

        $pixels = DB::table('pixels')->get();
        View::share('pixels', $pixels);

        $ganalytics = DB::table('ganalytics')->get();
        View::share('ganalytics', $ganalytics);

        $welcomechats = DB::table('welcomechats')->get();
        View::share('welcomechats', $welcomechats);

if (config('app.env') === 'production') {
        URL::forceScheme('https');
    }
        

        Paginator::defaultView('vendor.pagination.custom');
    }
}
