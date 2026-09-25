<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Dukungan;
use Illuminate\Support\Str;

class dukunganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dukungans = Dukungan::oldest()->when(request()->q, function ($dukungans) {
            $dukungans = $dukungans->where('name', 'like', '%' . request()->q . '%');
        })->paginate(20);

        return view('admin.dukungan.index', compact('dukungans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dukungan.create');
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
        $image->storeAs('public/dukungans', $image->hashName());

        //save to DB
        $dukungan = Dukungan::create([
            'image'             => $image->hashName(),
            'title'              => $request->title,
            'slug'              => Str::slug($request->title, '-'),
            'name'              => $request->name,
            'jabatan'           => $request->jabatan,
            'id_yt'           => $request->id_yt,
        ]);

        if ($dukungan) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.dukungan.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('admin.dukungan.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Dukungan $dukungan)
    {
        return view('admin.dukungan.edit', compact('dukungan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dukungan $dukungan)
    {
        $this->validate($request, [
            'title'         => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,webp|max:1000',
        ]);

        //check jika image kosong
        if ($request->file('image') == '') {

            //update data tanpa image
            $dukungan = Dukungan::findOrFail($dukungan->id);
            $dukungan->update([
                'title'                 => $request->title,
                'slug'              => Str::slug($request->title, '-'),
                'name'              => $request->name,
                'jabatan'           => $request->jabatan,
                'id_yt'           => $request->id_yt,
            ]);
        } else {

            //hapus image lama
            Storage::disk('local')->delete('public/dukungans/' . basename($dukungan->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/dukungans', $image->hashName());

            //update dengan image baru
            $dukungan = Dukungan::findOrFail($dukungan->id);
            $dukungan->update([
                'image'             => $image->hashName(),
                'title'              => $request->title,
                'slug'              => Str::slug($request->title, '-'),
                'name'              => $request->name,
                'jabatan'           => $request->jabatan,
                'id_yt'           => $request->id_yt,
            ]);
        }

        if ($dukungan) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.dukungan.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('admin.dukungan.index')->with(['error' => 'Data Gagal Diupdate!']);
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
        $dukungan = Dukungan::findOrFail($id);
        Storage::disk('local')->delete('public/dukungans/' . basename($dukungan->image));
        $dukungan->delete();

        if ($dukungan) {
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

        $dukungans = Dukungan::whereIn('id', $ids)->get();

        foreach ($dukungans as $dukungan) {
            Storage::disk('local')->delete('public/dukungans/' . $dukungan->image);
            $dukungan->delete();
        }

        return response()->json(['status' => 'success']);
    }
}
