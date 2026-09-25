<?php

namespace App\Http\Controllers\Admin;

use App\Models\Renstra;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class RenstraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $renstras = Renstra::oldest()->when(request()->q, function($renstras) {
            $renstras = $renstras->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);
        

        return view('admin.renstra.index', compact('renstras'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.renstra.create');
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
            'title'  => 'required',
            'description'  => 'required'
        ]);
        $renstra = Renstra::create([
            'title'             => $request->title,
            'description'       => $request->description,

        ]);
 
        if($renstra){
            //redirect dengan pesan sukses
            return redirect()->route('admin.renstra.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.renstra.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * edit
     *
     * @param  mixed $request
     * @param  mixed $renstra
     * @return void
     */
    public function edit(renstra $renstra)
    {
        return view('admin.renstra.edit', compact('renstra'));
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $renstra
     * @return void
     */
    public function update(Request $request, renstra $renstra)
    {
        $this->validate($request, [
            'title'  => 'required',
            'description'  => 'required'
        ]); 

        $renstra = Renstra::findOrFail($renstra->id);
            $renstra->update([
                'title'   => $request->title,
                'description'   => $request->description,
            ]);

            if($renstra){
                //redirect dengan pesan sukses
                return redirect()->route('admin.renstra.index')->with(['success' => 'Data Berhasil Diupdate!']);
            }else{
                //redirect dengan pesan error
                return redirect()->route('admin.renstra.index')->with(['error' => 'Data Gagal Diupdate!']);
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
        $renstra = Renstra::findOrfail($id);
        Storage::disk('local')->delete('public/renstras/'.basename($renstra->image));
        $renstra->delete();

        if($renstra){
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