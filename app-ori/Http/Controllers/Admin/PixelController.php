<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Pixel;

class PixelController extends Controller
{
    public function index()
    {
        $pixels = Pixel::oldest()->take(1)->get();

        return view('admin.pixel.index', compact('pixels'));
    }


    public function edit($id)
    {
        $pixel = Pixel::findOrfail($id);
        return view('admin.pixel.edit', compact('pixel'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
        ]); 

        
            //update data tanpa image
            $pixel = Pixel::findOrfail($id);
            $pixel->update([
                'pixel_code'                   => $request->pixel_code,
            ]);


        if($pixel){
            //redirect dengan pesan sukses
            return redirect()->route('admin.pixel.edit',1)->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.pixel.edit',1)->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
}
