<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Header;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class HeaderController extends Controller
{

    public function index()
    {
        $headers = Header::orderBy('id', 'asc')->when(request()->q, function($headers) {
            $headers = $headers->where('name', 'like', '%'. request()->q . '%');
        })->paginate(100);

        return view('admin.header.index', compact('headers'));
    }


    public function edit($id)
    {
        $header = Header::findOrfail($id);
        return view('admin.header.edit', compact('header'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'         => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,webp|max:1000',
        ]); 

        //check jika image kosong
        if($request->file('image') == '') {
            
            //update data tanpa image
            $header = Header::findOrfail($id);
            $header->update([
                'title'                 => $request->title,
                'meta_desc'               => $request->meta_desc,
            ]);

        } else {
            $header = header::findOrfail($id);
            //hapus image lama
            Storage::disk('local')->delete('public/headers/'.basename($header->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/headers', $image->hashName());

            //update dengan image baru
            $header = header::findOrfail($id);
            $header->update([
                'image'                 => $image->hashName(),
                'title'                 => $request->title,
                'meta_desc'               => $request->meta_desc,
            ]);
        }

        if($header){
            //redirect dengan pesan sukses
            return redirect()->route('admin.header.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.header.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    
}
