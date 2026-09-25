<?php

namespace App\Http\Controllers;

use App\Models\Prosedur;
use Illuminate\Http\Request;
use App\Models\Header;
use App\Models\Sidebanner;


class ProsedurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $headers = Header::where('id', '=' , '6')->get();
        $prosedur = Prosedur::Oldest()->take(1)->get();
        $banners = Sidebanner::latest()->take(1)->get();

        return view('front.prosedur.index',compact('headers','prosedur','banners'));
    }
}
