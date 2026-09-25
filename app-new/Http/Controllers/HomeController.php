<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\About;
use App\Models\Sambutan;
use App\Models\Unggulan;
use App\Models\Post;
use App\Models\Agenda;
use App\Models\Testimony;
use App\Models\Prestasi;
use App\Models\Visi;
use App\Models\Misi;
use App\Models\Videoprofile;
use App\Models\Program;
use App\Models\Legal;
use App\Models\Partner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller\Admin;
use Carbon\Carbon;
use App\Models\Svg;
use App\Models\Renstra;


class HomeController extends Controller
{
    public function index(){
        $sliders = Slider::latest()->take(3)->get();
        $abouts = About::latest()->take(1)->get();
        $sambutans = Sambutan::latest()->take(1)->get();
        $posts = Post::orderBy('pub_date', 'desc')->where('pub_date', '<', Carbon::today())->take(3)->get();
        $agendas = Agenda::oldest()->where('end_date', '>', Carbon::today())->take(3)->get();
        $mainunggulan = Unggulan::oldest()->take(1)->get();
        $unggulans = Unggulan::oldest()->take(5)->get();
        $testimonies = Testimony::latest()->take(4)->get();
        $prestasiimage = Prestasi::orderBy('created_at', 'asc')->get();
        $partners = Partner::oldest()->get();
        $svgs = Svg::latest()->get();
        $visis = Visi::all();
        $misis = Misi::all();
        $legals = Legal::latest()->get();
        $videoprofiles = Videoprofile::all();
        $programhome = Program::oldest()->get();
        $agendas = Agenda::oldest()->where('end_date', '>', Carbon::today())->take(2)->get();
        
        return view('front.frontpage.index', compact('sliders','visis','abouts','sambutans','unggulans','posts','mainunggulan','agendas','testimonies','svgs','videoprofiles','programhome','agendas','misis','legals','prestasiimage','partners'));
    }

   
}
