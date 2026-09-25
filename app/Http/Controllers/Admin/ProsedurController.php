<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prosedur;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProsedurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prosedur=Prosedur::Oldest()->take(1)->get();

        return view('admin.prosedur.index', compact('prosedur'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Prosedur $prosedur)
    {
        return view('admin.prosedur.edit', compact('prosedur'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prosedur $prosedur)
    {
        $this->validate($request, [
            'content'           => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,webp|max:1000',
        ]); 
        
        //check if image is not present
        if (!$request->hasFile('image')) {
            
            //update data without image
            $prosedur->update([
                'title'                  => $request->title,
                'content'                  => $request->content,
            ]);
        } else {
            //delete old image
            Storage::disk('local')->delete('public/identities/'.basename($prosedur->image));

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/identities', $image->hashName());

            //update with new image
            $prosedur->update([
                'title'                  => $request->title,
                'content'                  => $request->content,
                'image'             => $image->hashName(),
            ]);
        }

        if ($prosedur) {
            //redirect with success message
            return redirect()->route('admin.prosedur.edit',$prosedur->id)->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            //redirect with error message
            return redirect()->route('admin.prosedur.edit',$prosedur->id)->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
}
