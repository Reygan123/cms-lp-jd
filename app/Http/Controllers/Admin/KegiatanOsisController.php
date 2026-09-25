<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KegiatanOsis;
use Illuminate\Support\Facades\Storage;

class KegiatanOsisController extends Controller
{
    public function index()
    {
        $kegiatans = KegiatanOsis::orderBy('created_at','ASC')->paginate(10);
        return view('admin.osis.index',compact('kegiatans'));
    }

    public function create()
    {
        return view('admin.osis.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'image'            => 'required',
            'name'             => 'required',
            'description'      => 'required'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/osis', $image->hashName());

        $osis = KegiatanOsis::create([
                'image'                => $image->hashName(),
                'name'                   => $request->name,
                'description'           => $request->description,
        ]);
 
        if($osis){
            //redirect dengan pesan sukses
            return redirect()->route('admin.osis.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.osis.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }


}
