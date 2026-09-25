<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Misi;
use Illuminate\Support\Facades\Storage;


class MisiController extends Controller
{
    public function index()
    {
        $misis = Misi::all();
        return view('admin.misi.index', compact('misis'));
    }


    public function edit($id)
    {
        $misi = Misi::findOrfail($id);
        return view('admin.misi.edit', compact('misi'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'         => 'required',
            'misi'         => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,webp|max:1000',
        ]); 

        //check jika image kosong
        if($request->file('image') == '') {
            
            //update data tanpa image
            $misi = misi::findOrfail($id);
            $misi->update([
                'title'                 => $request->title,
                'subtitle'                 => $request->subtitle,
                'misi'                  => $request->misi,
            ]);

        } else {
            $misi = misi::findOrfail($id);
            //hapus image lama
            Storage::disk('local')->delete('public/identities/'.basename($misi->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/identities', $image->hashName());

            //update dengan image baru
            $misi = misi::findOrfail($id);
            $misi->update([
                'image'                 => $image->hashName(),
                'subtitle'                 => $request->subtitle,
                'title'                 => $request->title,
                'misi'                  =>$request->misi,
            ]);
        }

        if($misi){
            //redirect dengan pesan sukses
            return redirect()->route('admin.about.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.about.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

}
