<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;
use App\Models\Header;
use App\Models\Program;
use App\Models\Titlebenefit;
use App\Models\Benefit;

class FfacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $headers = Header::where('id', '=', '3')->get();
        $facilities = Facility::Oldest()->get();

        return view('front.assessment.index', compact('facilities', 'headers'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Facility  $post
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $headers = Header::where('id', 3)->get();
        $programs = Program::oldest()->get();
        $facility = Facility::where('slug', $slug)->firstOrFail();
        $titles = Titlebenefit::latest()->take(1)->get();
        $benefits = Benefit::where('facility_id', $facility->id)->get();

        return view('front.assessment.show', compact('facility', 'headers','programs','titles','benefits'));
    }
}
