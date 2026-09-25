<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alumni;
use Illuminate\Support\Facades\Storage;

class AlumniController extends Controller
{
    public function index()
    {
        $alumnis = Alumni::orderBy('created_at', 'ASC')->paginate(10);
        return view('admin.alumni.index', compact('alumnis'));
    }

    public function create()
    {
        return view('admin.alumni.create');
    }

    public function store(Request $request)
    {
        //upload image
        $image = $request->file('image');
        $image->storeAs('public/alumnis', $image->hashName());

        $alumni = Alumni::create([
            'image'                => $image->hashName(),
            'name'                   => $request->name,
            'angkatan'              => $request->angkatan,
            'alamat'                   => $request->alamat,
            'intansi'             => $request->intansi,
            'pekerjaan'             => $request->pekerjaan,
            'email'                 => $request->email,
            'no_hp'                => $request->no_hp,
            'description'                => $request->description,
        ]);

        if ($alumni) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.alumni.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('admin.alumni.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function edit($id)
    {
        $alumni = Alumni::findOrfail($id);
        return view('admin.alumni.edit', compact('alumni'));
    }

    public function update(Request $request, $id)
    {

        //check jika image kosong
        if ($request->file('image') == null) {

            //update data tanpa image
            $alumni = Alumni::findOrFail($id);
            $alumni->update([
                'name'                   => $request->name,
                'angkatan'              => $request->angkatan,
                'alamat'                   => $request->alamat,
                'intansi'             => $request->intansi,
                'pekerjaan'             => $request->pekerjaan,
                'email'                 => $request->email,
                'no_hp'                => $request->no_hp,
                'description'                => $request->description,
            ]);
        } else {
            $alumni = Alumni::findOrFail($id);
            //hapus image lama
            Storage::disk('local')->delete('public/alumnis/' . basename($alumni->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/alumnis', $image->hashName());

            //update dengan image baru
            $alumni->update([
                'image'                 => $image->hashName(),
                'name'                   => $request->name,
                'angkatan'              => $request->angkatan,
                'alamat'                   => $request->alamat,
                'intansi'             => $request->intansi,
                'pekerjaan'             => $request->pekerjaan,
                'email'                 => $request->email,
                'no_hp'                => $request->no_hp,
                'description'                => $request->description,
            ]);
        }

        if ($alumni) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.alumni.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('admin.alumni.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    public function destroy($id)
    {
        $alumni = Alumni::findOrFail($id);
        Storage::disk('local')->delete('public/alumnis/' . basename($alumni->image));
        $alumni->delete();

        if ($alumni) {
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

        $alumnis = Alumni::whereIn('id', $ids)->get();

        foreach ($alumnis as $alumni) {
            Storage::disk('local')->delete('public/alumnis/' . $alumni->image);
            $alumni->delete();
        }

        return response()->json(['status' => 'success']);
    }

    
}
