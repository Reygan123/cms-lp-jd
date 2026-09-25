<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Prestasi;
use App\Models\Program;
use App\Models\Categoriprestasi;
use Illuminate\Support\Str;

class PrestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prestasis = Prestasi::latest()->when(request()->q, function ($prestasis) {
            $prestasis = $prestasis->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('admin.prestasi.index', compact('prestasis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoriprestasis = Categoriprestasi::latest()->get();
        $programs = Program::latest()->get();
        return view('admin.prestasi.create', compact('categoriprestasis', 'programs'));
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
            'image'                 => 'required|image|mimes:jpeg,jpg,png,webp|max:1000',
            'title'                 => 'required',
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/prestasis', $image->hashName());

        //save to DB
        $prestasi = Prestasi::create([
            'image'                     => $image->hashName(),
            'title'                     => $request->title,
            'slug'                      => Str::slug($request->name, '-'),
            'categoriprestasi_id'       => $request->categoriprestasi_id,
            'program_id'                => $request->program_id,
            'name'                      => $request->name,
            'home'                      => $request->home,
        ]);

        if ($prestasi) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.prestasi.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('admin.prestasi.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Prestasi $prestasi)
    {
        $categoriprestasis = Categoriprestasi::latest()->get();
        $programs = Program::latest()->get();
        return view('admin.prestasi.edit', compact('prestasi', 'categoriprestasis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prestasi $prestasi)
    {
        $this->validate($request, [
            'title'                 => 'required',
            'image'                 => 'image|mimes:jpeg,jpg,png,webp|max:1000',
        ]);

        //check jika image kosong
        if ($request->file('image') == '') {

            //update data tanpa image
            $prestasi = Prestasi::findOrFail($prestasi->id);
            $prestasi->update([
                'title'                     => $request->title,
                'slug'                      => Str::slug($request->name, '-'),
                'categoriprestasi_id'       => $request->categoriprestasi_id,
                'program_id'                => $request->program_id,
                'name'                      => $request->name,
                'home'                      => $request->home,

            ]);
        } else {

            //hapus image lama
            Storage::disk('local')->delete('public/prestasis/' . basename($prestasi->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/prestasis', $image->hashName());

            //update dengan image baru
            $prestasi = Prestasi::findOrFail($prestasi->id);
            $prestasi->update([
                'image'                     => $image->hashName(),
                'title'                     => $request->title,
                'slug'                      => Str::slug($request->name, '-'),
                'categoriprestasi_id'       => $request->categoriprestasi_id,
                'program_id'                => $request->program_id,
                'name'                      => $request->name,
                'home'                      => $request->home,

            ]);
        }

        if ($prestasi) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.prestasi.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('admin.prestasi.index')->with(['error' => 'Data Gagal Diupdate!']);
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
        $prestasi = Prestasi::findOrFail($id);
        Storage::disk('local')->delete('public/prestasis/' . basename($prestasi->image));
        $prestasi->delete();

        if ($prestasi) {
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

        $prestasis = Prestasi::whereIn('id', $ids)->get();

        foreach ($prestasis as $prestasi) {
            Storage::disk('local')->delete('public/prestasis/' . $prestasi->image);
            $prestasi->delete();
        }

        return response()->json(['status' => 'success']);
    }
}
