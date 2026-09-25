<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seragam;
use Illuminate\Support\Facades\Storage;

class SeragamController extends Controller
{
    public function index()
    {
        $seragams = Seragam::orderBy('created_at','ASC')->paginate(10);
        return view('admin.seragam.index', compact('seragams'));
    }

    public function create()
    {
        return view('admin.seragam.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image'                 => 'required|image|mimes:jpeg,jpg,png,webp|max:1000',
            'name'             => 'required',
            'description'      => 'required'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/seragams', $image->hashName());

        $seragam = seragam::create([
                'image'                => $image->hashName(),
                'name'                   => $request->name,
                'description'           => $request->description,
        ]);
 
        if($seragam){
            //redirect dengan pesan sukses
            return redirect()->route('admin.seragam.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.seragam.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function edit(Seragam $seragam)
    {
        return view('admin.seragam.edit', compact('seragam'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seragam $seragam)
    {
        $this->validate($request, [
            'name'             => 'required',
            'description'      => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,webp|max:1000',
        ]); 

        //check jika image kosong
        if($request->file('image') == '') {
            
            //update data tanpa image
            $seragam = Seragam::findOrFail($seragam->id);
            $seragam->update([
                'name'                   => $request->name,
                'description'           => $request->description,
            ]);

        } else {

            //hapus image lama
            Storage::disk('local')->delete('public/seragams/'.basename($seragam->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/seragams', $image->hashName());

            //update dengan image baru
            $seragam = Seragam::findOrFail($seragam->id);
            $seragam->update([
                'image'                => $image->hashName(),
                'name'                   => $request->name,
                'description'           => $request->description,
            ]);
        }

        if($seragam){
            //redirect dengan pesan sukses
            return redirect()->route('admin.seragam.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.seragam.index')->with(['error' => 'Data Gagal Diupdate!']);
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
        $seragam = Seragam::findOrFail($id);
        Storage::disk('local')->delete('public/seragams/'.basename($seragam->image));
        $seragam->delete();

        if($seragam){
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
