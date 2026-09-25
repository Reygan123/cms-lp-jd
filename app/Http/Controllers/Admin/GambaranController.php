<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gambaran;
use Illuminate\Support\Facades\Storage;

class GambaranController extends Controller
{
    public function index()
    {
        $gambarans = Gambaran::orderBy('created_at','ASC')->paginate(10);
        return view('admin.gambaran.index',compact('gambarans'));
    }

    public function create()
    {
        return view('admin.gambaran.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image'            => 'required',
            'name'             => 'required'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/gambarans', $image->hashName());

        $gambaran = gambaran::create([
                'image'                => $image->hashName(),
                'name'                   => $request->name,
        ]);
 
        if($gambaran){
            //redirect dengan pesan sukses
            return redirect()->route('admin.gambaran.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.gambaran.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }
}
