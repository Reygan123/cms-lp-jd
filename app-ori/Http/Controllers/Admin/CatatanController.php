<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Catatan;
use Illuminate\Support\Str;

class CatatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $catatans = Catatan::latest()->when(request()->q, function($catatans) {
            $catatans = $catatans->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.catatan.index', compact('catatans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.catatan.create');
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
            'image'             => 'required|image|mimes:jpeg,jpg,png,webp|max:1000',
            'title'             => 'required',
        ]); 
 
        //upload image
        $image = $request->file('image');
        $image->storeAs('public/catatans', $image->hashName());
 
        //save to DB
        $catatan = Catatan::create([
            'image'             => $image->hashName(),
            'title'              => $request->title,
            'slug'              => Str::slug($request->title, '-'),
            'description'           => $request->description,
        ]);
 
        if($catatan){
             //redirect dengan pesan sukses
             return redirect()->route('admin.catatan.index')->with(['success' => 'Data Berhasil Disimpan!']);
         }else{
             //redirect dengan pesan error
             return redirect()->route('admin.catatan.index')->with(['error' => 'Data Gagal Disimpan!']);
         }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(catatan $catatan)
    {
        return view('admin.catatan.edit', compact('catatan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, catatan $catatan)
    {
        $this->validate($request, [
            'title'         => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,webp|max:1000',
        ]); 

        //check jika image kosong
        if($request->file('image') == '') {
            
            //update data tanpa image
            $catatan = Catatan::findOrFail($catatan->id);
            $catatan->update([
                'title'                 => $request->title,
                'slug'                  => Str::slug($request->title, '-'),
                'description'           => $request->description,
            ]);

        } else {

            //hapus image lama
            Storage::disk('local')->delete('public/catatans/'.basename($catatan->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/catatans', $image->hashName());

            //update dengan image baru
            $catatan = Catatan::findOrFail($catatan->id);
            $catatan->update([
                'image'             => $image->hashName(),
                'title'              => $request->title,
                'slug'              => Str::slug($request->title, '-'),
                'description'           => $request->description,
            ]);
        }

        if($catatan){
            //redirect dengan pesan sukses
            return redirect()->route('admin.catatan.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.catatan.index')->with(['error' => 'Data Gagal Diupdate!']);
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
        $catatan = catatan::findOrFail($id);
        Storage::disk('local')->delete('public/catatans/'.basename($catatan->image));
        $catatan->delete();

        if($catatan){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
