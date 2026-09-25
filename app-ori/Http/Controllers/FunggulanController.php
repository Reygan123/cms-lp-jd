<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unggulan;
use App\Models\Header;


class FunggulanController extends Controller
{
    public function index()
    {
        $unggulans = Unggulan::Oldest()->get();
        $headers = Header::where('id', '=', '5')->get();
        
        return view('front.unggulan.index', compact('unggulans','headers'));
    }
}
