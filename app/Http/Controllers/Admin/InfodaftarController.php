<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Infodaftar;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Storage;;

class InfodaftarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $infodaftars = Infodaftar::latest()->take(1)->get();

        return view('admin.infodaftar.index', compact('infodaftars'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Infodaftar $infodaftar)
    {
        return view('admin.infodaftar.edit', compact('infodaftar'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'title'         => 'required',
            'subtitle'         => 'required',
            'description'         => 'required',
            'text_investasi'         => 'required',
            'text_daftar'         => 'required',
        ]); 


            
            //update data tanpa image
            $infodaftar = Infodaftar::findOrfail($id);
            $infodaftar->update([
                'title'                 => $request->title,
                'subtitle'               => $request->subtitle,
                'description'            => $request->description,
                'text_investasi'                => $request->text_investasi,
                'text_daftar'                => $request->text_daftar,
            ]);

        

        if($infodaftar){
            //redirect dengan pesan sukses
            return redirect()->route('admin.infodaftar.edit',$infodaftar->id)->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.infodaftar.index',$infodaftar->id)->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

   
}
