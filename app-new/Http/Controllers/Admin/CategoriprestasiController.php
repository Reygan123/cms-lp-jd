<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoriprestasi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoriprestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoriprestasis = Categoriprestasi::latest()->when(request()->q, function($categoriprestasis) {
            $categoriprestasis = $categoriprestasis->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.categoriprestasi.index', compact('categoriprestasis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categoriprestasi.create');
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
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:1000',
            'name'  => 'required|unique:categoriprestasis' 
        ]); 
 
        //upload image
        $image = $request->file('image');
        $image->storeAs('public/categoriprestasis', $image->hashName());
 
        //save to DB
        $categoriprestasi = Categoriprestasi::create([
            'image'  => $image->hashName(),
            'name'   => $request->name,
            'slug'   => Str::slug($request->name, '-')
        ]);
 
        if($categoriprestasi){
             //redirect dengan pesan sukses
             return redirect()->route('admin.categoriprestasi.index')->with(['success' => 'Data Berhasil Disimpan!']);
         }else{
             //redirect dengan pesan error
             return redirect()->route('admin.categoriprestasi.index')->with(['error' => 'Data Gagal Disimpan!']);
         }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function edit(Categoriprestasi $categoriprestasi)
    {
        return view('admin.categoriprestasi.edit', compact('categoriprestasi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  mixed $request
     * @param  mixed $categoriprestasi
     * @return void
     */
    public function update(Request $request, Categoriprestasi $categoriprestasi)
    {
        $this->validate($request, [
            'name'  => 'required|unique:categoriprestasis,name,'.$categoriprestasi->id ,
            'image' => 'image|mimes:jpeg,jpg,png,webp|max:1000',
        ]); 

        //check jika image kosong
        if($request->file('image') == '') {
            
            //update data tanpa image
            $categoriprestasi = Categoriprestasi::findOrFail($categoriprestasi->id);
            $categoriprestasi->update([
                'name'   => $request->name,
                'slug'   => Str::slug($request->name, '-')
            ]);

        } else {

            //hapus image lama
            Storage::disk('local')->delete('public/categoriprestasis/'.basename($categoriprestasi->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/categoriprestasis', $image->hashName());

            //update dengan image baru
            $categoriprestasi = Categoriprestasi::findOrFail($categoriprestasi->id);
            $categoriprestasi->update([
                'image'  => $image->hashName(),
                'name'   => $request->name,
                'slug'   => Str::slug($request->name, '-')
            ]);
        }

        if($categoriprestasi){
            //redirect dengan pesan sukses
            return redirect()->route('admin.categoriprestasi.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.categoriprestasi.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $categoriprestasi = Categoriprestasi::findOrFail($id);
        Storage::disk('local')->delete('public/categoriprestasis/'.basename($categoriprestasi->image));
        $categoriprestasi->delete();

        if($categoriprestasi){
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
