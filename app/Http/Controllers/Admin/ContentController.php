<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function index()
    {
        $content = content::all();
        return view('admin.content.index', compact('content'));
    }

    public function edit($id)
    {
        $content = content::findOrfail($id);
        return view('admin.content.edit', compact('content'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'         => 'required',
        ]); 

        //check jika image kosong
        if($request->file('image') == '') {
            
            //update data tanpa image
            $content = content::findOrfail($id);
            $content->update([
                'title'                   => $request->title,
                'slug'                   => Str::slug($request->title, '-'),
                'description'            => $request->description,
               
                
            ]);

        } else {
            $content = content::findOrfail($id);
            //hapus image lama
            Storage::disk('local')->delete('public/contents/'.basename($content->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/contents', $image->hashName());

            //update dengan image baru
            $content = content::findOrfail($id);
            $content->update([
                'image'                => $image->hashName(),
                'title'                 => $request->title,
                'slug'                  => Str::slug($request->title, '-'),
                'description'            => $request->description,
                
            ]);
        }

        if($content){
            //redirect dengan pesan sukses
            return redirect()->route('admin.content.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.content.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
}
