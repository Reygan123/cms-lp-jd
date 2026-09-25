<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Yutub;

class YutubController extends Controller
{
    public function index()
    {
        $yutub = Yutub::latest()->get();
        return view('admin.yutub.index', compact('yutub'));
    }

    public function create()
    {
        return view('admin.yutub.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'link'         => 'required',  
        ]); 

        $yutub = Yutub::create([
            'link' => $request -> link
        ]);

        if($yutub){
            //redirect dengan pesan sukses
            return redirect()->route('admin.yutub.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.yutub.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function edit($id)
    {
        $yutub = Yutub::findOrFail($id);
        return view('admin.yutub.edit', compact('yutub'));
    }

    public function update(Request $request, $id)
    {
        $yutub = Yutub::findOrFail($id);
        $yutub->update([
            'link' => $request->link,
            
        ]);
    
        if ($yutub) {
            return redirect()->route('admin.yutub.index')->with(['success' => 'Data berhasil diupdate']);
        } else {
            return redirect()->route('admin.yutub.index')->with(['error' => 'Data gagal diupdate']);
        }
    }
}
