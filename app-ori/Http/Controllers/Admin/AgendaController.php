<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agenda;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AgendaController extends Controller
{

    public function index()
    {
        $agendas = Agenda::latest()->when(request()->q, function ($agendas) {
            $agendas = $agendas->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('admin.agenda.index', compact('agendas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.agenda.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image'             => 'required|image|mimes:jpeg,jpg,png,webp|max:1000',
            'title'             => 'required',

        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/agendas', $image->hashName());

        $agenda = Agenda::create([
            'image'                 => $image->hashName(),
            'title'                 => $request->title,
            'slug'                  => Str::slug($request->title, '-'),
            'start_date'           => $request->start_date,
            'end_date'           => $request->end_date,
            'start_time'           => $request->start_time,
            'end_time'           => $request->end_time,
            'content'           => $request->content,
            'location'           => $request->location,
            'organizer'           => $request->organizer,
            'yt_link'           => $request->yt_link,
            'register_link'    => $request->register_link,
            'contact'    => $request->contact,

        ]);

        if ($agenda) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.agenda.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('admin.agenda.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }


    public function edit($id)
    {
        $agenda = Agenda::findOrfail($id);
        return view('admin.agenda.edit', compact('agenda'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,webp|max:1000',
        ]);

        $agenda = Agenda::findOrFail($id);

        if ($request->hasFile('image')) {
            // Remove old image
            Storage::disk('local')->delete('public/agendas/' . basename($agenda->image));

            // Upload new image
            $image = $request->file('image');
            $image->storeAs('public/agendas', $image->hashName());

            $agenda->update([
                'image' => $image->hashName(),
            ]);
        }

        $agenda->update([
            'title'      => $request->title,
            'slug'       => Str::slug($request->title, '-'),
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
            'content'    => $request->content,
            'location'   => $request->location,
            'organizer'   => $request->organizer,
            'yt_link'    => $request->yt_link,
            'register_link'    => $request->register_link,
            'contact'    => $request->contact,
        ]);

        if ($agenda) {
            return redirect()->route('admin.agenda.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            return redirect()->route('admin.agenda.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        Storage::disk('local')->delete('public/agendas/' . basename($agenda->image));
        $agenda->delete();

        if ($agenda) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
    public function massDestroy(Request $request)
    {
        $ids = $request->ids;

        $agendas = Agenda::whereIn('id', $ids)->get();

        foreach ($agendas as $agenda) {
            Storage::disk('local')->delete('public/agendas/' . $agenda->image);
            $agenda->delete();
        }

        return response()->json(['status' => 'success']);
    }
}
