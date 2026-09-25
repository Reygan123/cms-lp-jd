<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ourteamopening;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class OurteamopeningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ourteamopenings = Ourteamopening::oldest()->when(request()->q, function($ourteamopenings) {
            $ourteamopenings = $ourteamopenings->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);
        

        return view('admin.ourteam.index', compact('ourteamopenings'));

    }

    /**
     * edit
     *
     * @param  mixed $request
     * @param  mixed $Ourteamopening
     * @return void
     */
    public function edit(Ourteamopening $ourteamopening)
    {
        return view('admin.ourteamopening.edit', compact('ourteamopening'));
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $ourteamopening
     * @return void
     */
    public function update(Request $request, Ourteamopening $ourteamopening)
    {
        $this->validate($request, [
            'title'  => 'required',
        ]); 

        
            
            //update data tanpa image
            $ourteamopening = Ourteamopening::findOrFail($ourteamopening->id);
            $ourteamopening->update([
                'title'   => $request->title,
                'description'   => $request->description,
            ]);


        if($ourteamopening){
            //redirect dengan pesan sukses
            return redirect()->route('admin.ourteam.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.ourteam.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    
}