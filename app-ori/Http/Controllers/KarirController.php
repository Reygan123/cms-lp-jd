<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Header;

class KarirController extends Controller
{
    public function index()
    {
        $header = Header::where('id','=','16')->get();
        return view('front.karir.index',compact('header'));
    }
}
