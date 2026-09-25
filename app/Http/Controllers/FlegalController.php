<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Legal;
use App\Models\Header;

class FlegalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $legals = Legal::latest()->get();


        $headers = Header::where('id', '=', '14')->get();


        return view('front.legal.index', compact('legals','headers'));

    }
}
