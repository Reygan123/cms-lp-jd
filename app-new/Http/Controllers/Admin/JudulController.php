<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Judul;

class JudulController extends Controller
{
    public function index()
    {
        $juduls = Judul::oldest()->take(1)->get();

        return view('admin.judul.index', compact('juduls'));
    }


    public function edit($id)
    {
        $judul = Judul::findOrfail($id);
        return view('admin.judul.edit', compact('judul'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
        ]); 

        
            //update data tanpa image
            $judul = Judul::findOrfail($id);
            $judul->update([
                'title'                   => $request->title,
                'description'                   => $request->description,
            ]);


        if($judul){
            //redirect dengan pesan sukses
            return redirect()->route('admin.testimony.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.judul.edit',$judul->id)->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
}
