<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Models\Header;
use App\Models\Sidebanner;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $headers = Header::where('id','=','9')->get();
        $faq = Faq::orderBy('created_at' , 'ASC')->get();
        $banners = Sidebanner::latest()->take(1)->get();

        return view('front.faq.index', compact('headers','faq','banners'));
    }

}
