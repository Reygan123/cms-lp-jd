<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sidebanner;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SidebannerController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $sidebanners = Sidebanner::latest()->take(1)->get();

        return view('admin.sidebanner.index', compact('sidebanners'));
    }
    
    
    
    /**
     * edit
     *
     * @param  mixed $request
     * @param  mixed $sidebanner
     * @return void
     */
    public function edit(Sidebanner $sidebanner)
    {
        return view('admin.sidebanner.edit', compact('sidebanner'));
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $sidebanner
     * @return void
     */
    public function update(Request $request, Sidebanner $sidebanner)
    {
        $this->validate($request, [
            'image'                 => 'nullable|image|mimes:jpeg,jpg,png|max:2000',
            'link'                 => 'required',
        ]); 

        //check jika image kosong
        if($request->file('image') == '') {
            
            //update data tanpa image
            $sidebanner = Sidebanner::findOrFail($sidebanner->id);
            $sidebanner->update([
                'link'   => $request->link,
            ]);

        } else {

            //hapus image lama
            Storage::disk('local')->delete('public/identities/'.basename($sidebanner->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/identities', $image->hashName());

            //update dengan image baru
            $sidebanner = Sidebanner::findOrFail($sidebanner->id);
            $sidebanner->update([
                'image'  => $image->hashName(),
                'link'   => $request->link,
            ]);
        }

        if($sidebanner){
            //redirect dengan pesan sukses
            return redirect()->route('admin.sidebanner.edit',$sidebanner->id)->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.sidebanner.edit',$sidebanner->id)->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
}