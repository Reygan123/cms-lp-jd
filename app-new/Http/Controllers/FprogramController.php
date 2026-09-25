<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Header;
use App\Models\Unggulan;
use App\Models\Testimony;
use App\Models\Pricing;
use App\Models\Slider;
use App\Models\Judul;
use App\Models\Portofolio;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FprogramController extends Controller
{

   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $program = Program::where('slug', $slug)->with('facilities')->with('dukungans')->firstOrFail();
        $header = Header::where('id', '=', '11')->get();
        $unggulans = Unggulan::where('program_id', $program->id)->get();
        $portfolios = Portofolio::where('program_id', $program->id)->get();
        $testimonies = Testimony::where('program_id', $program->id)->take(6)->get();
        $sliders = Slider::where('program_id', $program->id)->take(3)->get();
        $pricings = Pricing::where('program_id', $program->id)->take(3)->get();
        $juduls = Judul::latest()->take(1)->get();
        


        return view('front.program.show', compact('program','header','unggulans','portfolios','testimonies','sliders','juduls','pricings'));
    }
    
}
