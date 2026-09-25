<?php

namespace App\Http\Controllers;

use App\Models\Investasi;
use Illuminate\Http\Request;
use App\Models\Header;
use App\Models\Program;
use App\Models\Sidebanner;

class InvestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $headers = Header::where('id','=','7')->get();
        $investasi = Program::oldest()->get();
        $banners = Sidebanner::latest()->take(1)->get();

        return view('front.investasi.index',compact('headers','investasi','banners'));
    }

}
