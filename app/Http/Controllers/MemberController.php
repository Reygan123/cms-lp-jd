<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formdaftar;
use App\Models\Header;

class MemberController extends Controller
{
    public function index()
    {
        $headers = Header::where('id', '=', '8')->get();
        $formdaftars = Formdaftar::latest()->when(request()->q, function($formdaftars) {
            $formdaftars = $formdaftars->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('front.member.index',compact('formdaftars','headers'));
    }

    public function show($id)
    {
        $headers = Header::where('id', '=', '8')->get();
        $formdaftar = Formdaftar::findOrfail($id);
        return view('front.member.show',compact('formdaftar','headers'));
    }
}
