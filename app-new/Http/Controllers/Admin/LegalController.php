<?php

namespace App\Http\Controllers\Admin;

use App\Models\Legal;
use Illuminate\Support\Str; 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class LegalController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $legals = Legal::latest()->get();

        return view('admin.legal.index', compact('legals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.legal.create');
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
            'image'             => 'required|image|mimes:jpeg,jpg,png,webp|max:1500',
            'title'             => 'required',
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/identities', $image->hashName());

        $legal = Legal::create([
            'title'             => $request->title,
            'description'       => $request->description,
            'image'             => $image->hashName(),
        ]);

        if($legal){
            //redirect dengan pesan sukses
            return redirect()->route('admin.legal.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.legal.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * edit
     *
     * @param  mixed $request
     * @param  mixed $legal
     * @return void
     */
    public function edit(Legal $legal)
    {
        return view('admin.legal.edit', compact('legal'));
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $legal
     * @return void
     */
    public function update(Request $request, Legal $legal)
    {
        $this->validate($request, [
            'image'                 => 'nullable|image|mimes:jpeg,jpg,png|max:1500',
            'title'                 => 'required',
        ]); 
        
        //check if image is not present
        if (!$request->hasFile('image')) {
            
            //update data without image
            $legal->update([
                'title'                 => $request->title,
                'description'           => $request->description,
            ]);
        } else {
            //delete old image
            Storage::disk('local')->delete('public/identities/'.basename($legal->image));

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/identities', $image->hashName());

            //update with new image
            $legal->update([
                'image'                => $image->hashName(),
                'title'                => $request->title,
                'description'          => $request->description,
            ]);
        }

        if ($legal) {
            //redirect with success message
            return redirect()->route('admin.legal.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            //redirect with error message
            return redirect()->route('admin.legal.index')->with(['error' => 'Data Gagal Diupdate!']);
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
        $legal = Legal::findOrFail($id);
        Storage::disk('local')->delete('public/identities/'.basename($legal->image));
        $legal->delete();

        if($legal){
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
