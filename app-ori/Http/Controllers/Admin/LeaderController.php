<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leader;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leaders = Leader::oldest()->when(request()->q, function($leaders) {
            $leaders = $leaders->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);
        
        return view('admin.leader.index', compact('leaders'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.leader.create');
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
        $image->storeAs('public/leaders', $image->hashName());

        $leader = Leader::create([
            'title'             => $request->title,
            'slug'              => Str::slug($request->title, '-'),
            'name'              => $request->name,
            'fb'                => $request->fb,
            'ig'                => $request->ig,
            'tt'                => $request->tt,
            'email'             => $request->email,
            'image'             => $image->hashName()
        ]);
 
        if($leader){
            //redirect dengan pesan sukses
            return redirect()->route('admin.leader.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.leader.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(leader $leader)
    {
        return view('admin.leader.edit', compact('leader'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, leader $leader)
    {
        $this->validate($request, [
            'title'             => 'required',
            'name'              => 'required',
            'email'             => 'required'
        ]); 

        //check jika image kosong
        if($request->file('image') == '') {
            
            //update data tanpa image
            $leader = Leader::findOrFail($leader->id);
            $leader->update([
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
            Storage::disk('local')->delete('public/leaders/'.basename($leader->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/leaders', $image->hashName());

            //update dengan image baru
            $leader = Leader::findOrFail($leader->id);
            $leader->update([
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

        if($leader){
            //redirect dengan pesan sukses
            return redirect()->route('admin.leader.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.leader.index')->with(['error' => 'Data Gagal Diupdate!']);
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
        $leader = Leader::findOrFail($id);
        Storage::disk('local')->delete('public/leaders/'.basename($leader->image));
        $leader->delete();

        if($leader){
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
