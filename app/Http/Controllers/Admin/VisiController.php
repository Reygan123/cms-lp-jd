<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visi;
use Illuminate\Support\Facades\Storage;

class VisiController extends Controller
{
    public function index()
    {
        $visi = Visi::all();
        return view('admin.visi.index', compact('visi'));
    }

    public function edit($id)
    {
        $visi = Visi::findOrfail($id);
        return view('admin.visi.edit', compact('visi'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'         => 'required',
            'visi'         => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,webp|max:1000',
        ]); 

        //check jika image kosong
        if($request->file('image') == '') {
            
            //update data tanpa image
            $visi = visi::findOrfail($id);
            $visi->update([
                'title'                 => $request->title,
                'subtitle'               => $request->subtitle,
                'visi'                  => $request->visi,
            ]);

        } else {
            $visi = visi::findOrfail($id);
            //hapus image lama
            Storage::disk('local')->delete('public/identities/'.basename($visi->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/identities', $image->hashName());

            //update dengan image baru
            $visi = visi::findOrfail($id);
            $visi->update([
                'image'                 => $image->hashName(),
                'title'                 => $request->title,
                'visi'                  =>$request->visi,
            ]);
        }

        if($visi){
            //redirect dengan pesan sukses
            return redirect()->route('admin.about.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.about.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    public function destroy($id)
    {
        //
    }
}
