<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Benefit;
use App\Models\Titlebenefit;
use App\Models\Header;
use Illuminate\Support\Str;

class FbenefitController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $benefits = Benefit::oldest()->when(request()->q, function($benefits) {
            $benefits = $benefits->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);

        $header = Header::where('id', '=', '6')->get();


        return view('front.benefit.index', compact('benefits','header'));

    }
    public function show($slug)
    {
        $benefit = Benefit::where('slug', $slug)->first();
        $benefits = Benefit::oldest()->take(5)->get();
        $header = Header::where('id', '=', '6')->get();
        $titles = Titlebenefit::latest()->take(1)->get();

        return view('front.benefit.show', compact('benefit','benefits','header','titles'));
    }
}
