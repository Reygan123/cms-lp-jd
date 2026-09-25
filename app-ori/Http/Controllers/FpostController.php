<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Header;
use App\Models\Post;
use App\Models\Category;
use App\Models\Agenda;
use App\Models\Sidebanner;

use Carbon\Carbon;


class FpostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::orderBy('pub_date', 'desc')
            ->where('pub_date', '<', Carbon::today());

        // Filter berdasarkan kategori jika ada parameter 'category'
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $posts->where('category_id', $category->id);
            }
        }

        // Filter berdasarkan query pencarian jika ada parameter 'q'
        $posts->when(request()->q, function($posts) {
            $posts->where('title', 'like', '%'. request()->q . '%');
        });

        $posts = $posts->paginate(10);

        $agendas = Agenda::oldest()->where('end_date', '>', Carbon::today())->take(3)->get();
        $headers = Header::where('id', '=', '10')->get();
        $banners = Sidebanner::latest()->take(1)->get();
        $categories = Category::latest()->get();

        return view('front.fpost.index', compact('posts', 'agendas', 'headers', 'banners', 'categories'));
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
        $post = Post::where('slug', $slug)->first();
        $posts = Post::orderBy('pub_date', 'desc')->where('pub_date', '<', Carbon::today())->take(4)->get();
        $headers = Header::where('id', '=', '10')->get();
        $agendas = Agenda::oldest()->where('end_date', '>', Carbon::today())->take(3)->get();
        $banners = Sidebanner::latest()->take(1)->get();

        // Ambil postingan sebelumnya
        $previousPost = Post::where('pub_date', '<', $post->pub_date)
            ->orderBy('pub_date', 'desc')
            ->first();

        // Ambil postingan berikutnya
        $nextPost = Post::where('pub_date', '>', $post->pub_date)
            ->orderBy('pub_date', 'asc')
            ->first();

        return view('front.fpost.show', compact('post', 'categories', 'posts', 'agendas', 'headers', 'banners', 'previousPost', 'nextPost'));
    }

}
