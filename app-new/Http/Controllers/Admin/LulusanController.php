<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lulusan;

class LulusanController extends Controller
{
    public function index()
    {
        $lulusan = Lulusan::latest()->take(3)->get();
        return view('admin.lulusan.index', compact('lulusan'));
    }

    public function create()
    {
        return view('admin.lulusan.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'tahun'         => 'required', 
            'jumlah'          => 'required' 
        ]); 

        $lulusan = Lulusan::create([
            'tahun' => $request -> tahun,
            'jumlah' => $request -> jumlah
        ]);

        if($lulusan){
            //redirect dengan pesan sukses
            return redirect()->route('admin.lulusan.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.lulusan.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function edit($id)
    {
        $lulusan = Lulusan::findOrFail($id);
        return view('admin.lulusan.edit', compact('lulusan'));
    }

    public function update(Request $request, $id)
{
    $lulusan = Lulusan::findOrFail($id);
    $lulusan->update([
        'tahun' => $request->tahun,
        'jumlah' => $request->jumlah,
    ]);

    if ($lulusan) {
        return redirect()->route('admin.lulusan.index')->with(['success' => 'Data berhasil diupdate']);
    } else {
        return redirect()->route('admin.lulusan.index')->with(['error' => 'Data gagal diupdate']);
    }
}
}
