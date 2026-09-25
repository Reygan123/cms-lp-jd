<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Typedaftar;
use Illuminate\Support\Str;


class TypedaftarController extends Controller
{
    public function index()
    {
        $typedaftars = Typedaftar::oldest()->get();
        return view('admin.typedaftar.index', compact('typedaftars'));
    }

    public function edit(Typedaftar $typedaftar)
     {
         return view('admin.typedaftar.edit', compact('typedaftar'));
     }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'         => 'required',
        ]); 

        //update data tanpa image
        $typedaftar = Typedaftar::findOrfail($id);
        $typedaftar->update([
            'title'             => $request->title,
            'start_date'       => $request->start_date,
            'end_date'       => $request->end_date,
            'test_date'       => $request->test_date,
            'info_date'       => $request->info_date,
        ]);
        

        if($typedaftar){
            //redirect dengan pesan sukses
            return redirect()->route('admin.typedaftar.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.typedaftar.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    public function destroy($id)
    {
        $typedaftar = Typedaftar::findOrFail($id);
        $typedaftar->delete();

        if($typedaftar){
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
