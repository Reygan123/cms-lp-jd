<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Videoprofile;
use Illuminate\Support\Facades\Storage;

class VideoprofileController extends Controller
{
    public function index()
    {
        $videoprofiles = Videoprofile::all();
        return view('admin.videoprofile.index', compact('videoprofiles'));
    }

    public function edit(Videoprofile $videoprofile)
    {
        return view('admin.videoprofile.edit', compact('videoprofile'));
    }
    
    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'videoprofile'         => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,webp|max:1000',
        ]); 

        //check jika image kosong
        if($request->file('image') == '') {
            
            //update data tanpa image
            $videoprofile = Videoprofile::findOrfail($id);
            $videoprofile->update([
                'videoprofile'                 => $request->videoprofile,
            ]);

        } else {
            $videoprofile = Videoprofile::findOrfail($id);
            //hapus image lama
            Storage::disk('local')->delete('public/identities/'.basename($videoprofile->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/identities', $image->hashName());

            //update dengan image baru
            $videoprofile = Videoprofile::findOrfail($id);
            $videoprofile->update([
                'image'                => $image->hashName(),
                'videoprofile'                 => $request->videoprofile,
            ]);
        }

        if($videoprofile){
            //redirect dengan pesan sukses
            return redirect()->route('admin.about.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.about.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
}
