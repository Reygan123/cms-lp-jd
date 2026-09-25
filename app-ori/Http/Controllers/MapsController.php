<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Header;

class MapsController extends Controller
{
    public function index()
    {
        $header = Header::where('id','=','33')->get();
        return view('front.maps.index',compact('header'));
    }
}
