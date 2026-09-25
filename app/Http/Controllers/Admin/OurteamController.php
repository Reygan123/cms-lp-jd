<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ourteam;
use App\Models\Ourteamopening;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class OurteamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ourteams = Ourteam::oldest()->when(request()->q, function ($ourteams) {
            $ourteams = $ourteams->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);

        $ourteamopenings = Ourteamopening::latest()->take(1)->get();


        return view('admin.ourteam.index', compact('ourteams', 'ourteamopenings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.ourteam.create');
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
            'name'              => 'required',
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/ourteams', $image->hashName());

        $ourteam = Ourteam::create([
            'title'             => $request->title,
            'slug'              => Str::slug($request->title, '-'),
            'name'              => $request->name,
            'ot_id'              => $request->ot_id,
            'fb'                => $request->fb,
            'ig'                => $request->ig,
            'tt'                => $request->tt,
            'phone'                => $request->phone,
            'email'             => $request->email,
            'image'             => $image->hashName()
        ]);

        if ($ourteam) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.ourteam.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('admin.ourteam.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Ourteam $ourteam)
    {
        return view('admin.ourteam.edit', compact('ourteam'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ourteam $ourteam)
    {
        $this->validate($request, [
            'title'             => 'required',
            'name'              => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,webp|max:1000',
        ]);

        //check jika image kosong
        if ($request->file('image') == '') {

            //update data tanpa image
            $ourteam = Ourteam::findOrFail($ourteam->id);
            $ourteam->update([
                'title'             => $request->title,
                'slug'              => Str::slug($request->title, '-'),
                'name'              => $request->name,
                'ot_id'              => $request->ot_id,
                'fb'                => $request->fb,
                'ig'                => $request->ig,
                'tt'                => $request->tt,
                'phone'                => $request->phone,
                'email'             => $request->email,
            ]);
        } else {

            //hapus image lama
            Storage::disk('local')->delete('public/ourteams/' . basename($ourteam->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/ourteams', $image->hashName());

            //update dengan image baru
            $ourteam = Ourteam::findOrFail($ourteam->id);
            $ourteam->update([
                'title'             => $request->title,
                'slug'              => Str::slug($request->title, '-'),
                'name'              => $request->name,
                'ot_id'              => $request->ot_id,
                'fb'                => $request->fb,
                'ig'                => $request->ig,
                'tt'                => $request->tt,
                'phone'                => $request->phone,
                'email'                => $request->email,
                'image'             => $image->hashName()
            ]);
        }

        if ($ourteam) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.ourteam.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('admin.ourteam.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ourteam = Ourteam::findOrFail($id);
        Storage::disk('local')->delete('public/ourteams/' . basename($ourteam->image));
        $ourteam->delete();

        if ($ourteam) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
