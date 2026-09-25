<?php

namespace App\Http\Controllers;

use App\Models\Sejarah;
use App\Models\Sejarah1;
use App\Models\Sejarah2;
use App\Models\Header;
use Illuminate\Http\Request;
use Carbon\Carbon;


class FsejarahController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $sejarahs = Sejarah::latest()->take(1)->get();
        $sejarah1s = Sejarah1::latest()->take(1)->get();
        $sejarah2s = Sejarah2::latest()->take(1)->get();
        $headers = Header::where('id', '=', '3')->get();

        return view('front.pages.sejarah', compact('sejarahs','sejarah1s','sejarah2s','headers'));
    }
}
