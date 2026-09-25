<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ourteam;
use App\Models\Opening;
use App\Models\Header;
use Carbon\Carbon;

class OurteamController extends Controller
{
    public function index()
    {
        $ourteams = Ourteam::whereIn('ot_id', [3, 4, 5])->oldest()->get();

        $headers = Header::where('id', '=', 2)->get();

        return view('front.ourteam.index', compact('ourteams', 'headers'));
    }
}
