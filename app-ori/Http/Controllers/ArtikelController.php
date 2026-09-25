<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Agenda;
use App\Models\Header;
use App\Models\Category;
use Carbon\Carbon;
use App\Models\Sidebanner;

class ArtikelController extends Controller
{
    public function index()
    {
        
        $agendas = Agenda::oldest()->where('end_date', '>', Carbon::today())->take(4)->get();
        $headers = Header::where('id', '=', '11')->get();
        $posts = Post::orderBy('pub_date', 'desc')->where('category_id','=','2')->where('pub_date', '<', Carbon::today())->when(request()->q, function($posts) {
            $posts = $posts->where('title', 'like', '%'. request()->q . '%');
        })->paginate(6);
        $banners = Sidebanner::latest()->take(1)->get();
        return view('front.artikel.index',compact('posts','agendas','headers','banners'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $categories = Category::latest()->get();
        $artikel = Post::where('slug', $slug)->first();
        $headers = Header::where('id', '=', '11')->get();
        $posts = Post::orderBy('pub_date', 'desc')->where('pub_date', '<', Carbon::today())->take(4)->get();
        $agendas = Agenda::oldest()->where('end_date', '>', Carbon::today())->take(4)->get();
        $banners = Sidebanner::latest()->take(1)->get();

        return view('front.artikel.show', compact('artikel','categories','posts','agendas','headers','banners'));
    }
}
