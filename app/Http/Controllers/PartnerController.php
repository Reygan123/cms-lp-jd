<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;
use App\Models\Header;
use Carbon\Carbon;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partners = Partner::oldest()->when(request()->q, function($partners) {
            $partners = $partners->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);

        $headers = Header::where('id', '=', '15')->get();


        return view('front.partner.index', compact('partners','headers'));

    }
    public function show($id)
    {
        $partner = Partner::findOrfail($id);
        return view('front.partner.show', compact('partner'));
    }
}
