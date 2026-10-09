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
        $partners = Partner::latest()
            ->when(request()->q, function($query) {
                $query->where('name', 'like', '%'. request()->q . '%');
            })
            ->when(request()->category, function($query) {
                $query->where('category', request()->category);
            })
            ->when(request()->level, function($query) {
                $query->where('level', request()->level);
            })
            ->paginate(10);

        $headers = Header::where('id', '=', '15')->get();


        return view('front.partner.index', compact('partners','headers'));

    }
    public function show($id)
    {
        $partner = Partner::findOrfail($id);
        return view('front.partner.show', compact('partner'));
    }
}
