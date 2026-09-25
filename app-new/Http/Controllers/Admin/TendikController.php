<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tendik;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TendikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tendiks = tendik::oldest()->when(request()->q, function($tendiks) {
            $tendiks = $tendiks->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);
        
        return view('admin.tendik.index', compact('tendiks'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tendik.create');
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
            'image'             => 'nullable|image|mimes:jpeg,jpg,png|max:2000',
            'title'             => 'required',
            'name'              => 'required',
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/tendiks', $image->hashName());

        $tendik = tendik::create([
            'title'             => $request->title,
            'slug'              => Str::slug($request->title, '-'),
            'name'              => $request->name,
            'fb'                => $request->fb,
            'ig'                => $request->ig,
            'tt'                => $request->tt,
            'image'             => $image->hashName()
        ]);
 
        if($tendik){
            //redirect dengan pesan sukses
            return redirect()->route('admin.tendik.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.tendik.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(tendik $tendik)
    {
        return view('admin.tendik.edit', compact('tendik'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tendik $tendik)
    {
        $this->validate($request, [
            'title'             => 'required',
            'name'              => 'required',
        ]); 

        //check jika image kosong
        if($request->file('image') == '') {
            
            //update data tanpa image
            $tendik = tendik::findOrFail($tendik->id);
            $tendik->update([
                'title'             => $request->title,
                'slug'              => Str::slug($request->title, '-'),
                'name'              => $request->name,
                'fb'                => $request->fb,
                'ig'                => $request->ig,
                'tt'                => $request->tt,
                'email'             => $request->email,
            ]);

        } else {

            //hapus image lama
            Storage::disk('local')->delete('public/tendiks/'.basename($tendik->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/tendiks', $image->hashName());

            //update dengan image baru
            $tendik = tendik::findOrFail($tendik->id);
            $tendik->update([
                'title'             => $request->title,
                'slug'              => Str::slug($request->title, '-'),
                'name'              => $request->name,
                'fb'                => $request->fb,
                'ig'                => $request->ig,
                'tt'                => $request->tt,
                'email'                => $request->email,
                'image'             => $image->hashName()
            ]);
        }

        if($tendik){
            //redirect dengan pesan sukses
            return redirect()->route('admin.tendik.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.tendik.index')->with(['error' => 'Data Gagal Diupdate!']);
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
        $tendik = tendik::findOrFail($id);
        Storage::disk('local')->delete('public/tendiks/'.basename($tendik->image));
        $tendik->delete();

        if($tendik){
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
