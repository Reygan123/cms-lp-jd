<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\About;
use App\Models\Visi;
use App\Models\Misi;
use App\Models\Header;
use App\Models\Testimony;
use App\Models\Ourteam;
use App\Models\Ourteamopening;
use App\Models\Svg;
use App\Models\Sambutan;
use App\Models\Story;
use App\Models\Judul;

class AboutController extends Controller
{
    public function index()
    {

    $abouts = About::all();
    $visis = Visi::all();
    $misis = Misi::all();
    $testimonies = Testimony::where('home', '=', '1')->oldest()->get();
    $juduls = Judul::all();
    $penasehats = Ourteam::where('ot_id', '=', '1')->oldest()->get();
    $pakars = Ourteam::where('ot_id', '=', '6')->oldest()->get();
    $direkturs = Ourteam::where('ot_id', '=', '2')->oldest()->get();
    $ourteamopenings = Ourteamopening::oldest()->take(1)->get();
    $stories = Story::oldest()->get();
    $sambutans = Sambutan::oldest()->take(1)->get();
    $svgs = Svg::latest()->get();
    $headers = Header::where('id', '=', '1')->get();

    return view('front.about.index',compact('abouts','visis','misis','testimonies','svgs','headers','sambutans','stories','ourteamopenings','penasehats','direkturs','juduls', 'pakars'));
    
    }
}
