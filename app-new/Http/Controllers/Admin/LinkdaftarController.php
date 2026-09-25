<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Linkdaftar;


class LinkdaftarController extends Controller
{
    public function index()
    {
    $linkdaftars = Linkdaftar::all();

    return view('admin.linkdaftar.index', compact('linkdaftars'));
    }

    public function edit($id)
    {
        $linkdaftar = Linkdaftar::findOrfail($id);
        return view('admin.linkdaftar.edit', compact('linkdaftar'));
    }
    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'link'         => 'required',
            'linktext'         => 'required',
        ]); 

            
            //update data tanpa image
            $linkdaftar = Linkdaftar::findOrfail($id);
            $linkdaftar->update([
                'link'                => $request->link,
                'linktext'           => $request->linktext,
            ]);

       

        if($linkdaftar){
            //redirect dengan pesan sukses
            return redirect()->route('admin.linkdaftar.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.linkdaftar.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
}
