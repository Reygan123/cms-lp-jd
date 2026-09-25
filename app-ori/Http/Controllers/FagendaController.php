<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Header;
use App\Models\Post;
use App\Models\Sidebanner;
use Illuminate\Http\Request;
use Carbon\Carbon;


class FagendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agendas = Agenda::oldest()
        ->where('end_date', '>', Carbon::today())
        ->when(request()->q, function($agendas) {$agendas = $agendas->where('title', 'like', '%'. request()->q . '%');})
        ->paginate(10);

        $agendaolds = Agenda::oldest()->where('end_date', '<', Carbon::today())->take(3)->get();
        $posts = Post::orderBy('pub_date', 'desc')->where('pub_date', '<', Carbon::today())->take(4)->get();
        $headers = Header::where('id', '=', '12')->get();
        $banners = Sidebanner::latest()->take(1)->get();
        
        return view('front.fagenda.index', compact('agendas','agendaolds','posts','headers','banners'));
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $agendas = Agenda::oldest()
        ->where('end_date', '>', Carbon::today())
        ->take(3)->get();
        $agenda = Agenda::where('slug', $slug)->first();
        $posts = Post::orderBy('pub_date', 'desc')->where('pub_date', '<', Carbon::today())->take(4)->get();
        $headers = Header::where('id', '=', '12')->get();
        $banners = Sidebanner::latest()->take(1)->get();

        // Ambil postingan sebelumnya
        $previousAgenda = Agenda::where('start_date', '<', $agenda->start_date)
            ->orderBy('start_date', 'desc')
            ->first();

        // Ambil postingan berikutnya
        $nextAgenda = Agenda::where('start_date', '>', $agenda->start_date)
            ->orderBy('start_date', 'asc')
            ->first();


        return view('front.fagenda.show', compact('agenda','agendas','posts','headers','banners','previousAgenda','nextAgenda'));
    }
}
