<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Social;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SocialController extends Controller
{
    public function index()
    {
        $social = Social::all();
        return view('admin.social.index', compact('social'));
    }

    public function edit($id)
    {
        $socials = Social::findOrfail($id);
        return view('admin.social.edit', compact('socials'));
    }

    public function update(Request $request, $id)
    {
        //check jika image kosong
        if($request->file('image') == '') {
            
            //update data tanpa image
            $social = social::findOrfail($id);
            $social->update([
                'name'                   => $request->name,
                'slug'                   => Str::slug($request->name, '-'),
                'description'            => $request->description,
                'location'               => $request->location,
                
            ]);

        } else {
            $social = social::findOrfail($id);
            //hapus image lama
            Storage::disk('local')->delete('public/socials/'.basename($social->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/socials', $image->hashName());

            //update dengan image baru
            $social = social::findOrfail($id);
            $social->update([
                'image'                => $image->hashName(),
                'name'                 => $request->name,
                'slug'                 => Str::slug($request->name, '-'),
                'description'          => $request->description,
                'location'             => $request->location,
                
            ]);
        }

        if($social){
            //redirect dengan pesan sukses
            return redirect()->route('admin.social.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.social.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
}