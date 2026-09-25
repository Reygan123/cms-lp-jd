<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Facility;
use Illuminate\Support\Str;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facilities = Facility::oldest()->when(request()->q, function($facilities) {
            $facilities = $facilities->where('name', 'like', '%'. request()->q . '%');
        })->paginate(20);

        return view('admin.facility.index', compact('facilities'));
    }

   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.facility.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image'             => 'required|image|mimes:jpeg,jpg,png,webp|max:1000',
            'title'             => 'required',
        ]); 
 
        //upload image
        $image = $request->file('image');
        $image->storeAs('public/facilities', $image->hashName());
 
        //save to DB
        $facility = Facility::create([
            'image'             => $image->hashName(),
            'title'              => $request->title,
            'slug'              => Str::slug($request->title, '-'),
            'subtitle'           => $request->subtitle,
            'description'           => $request->description,
        ]);
 
        if($facility){
             //redirect dengan pesan sukses
             return redirect()->route('admin.facility.index')->with(['success' => 'Data Berhasil Disimpan!']);
         }else{
             //redirect dengan pesan error
             return redirect()->route('admin.facility.index')->with(['error' => 'Data Gagal Disimpan!']);
         }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(facility $facility)
    {
        return view('admin.facility.edit', compact('facility'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, facility $facility)
    {
        $this->validate($request, [
            'title'         => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,webp|max:1000',
        ]); 

        //check jika image kosong
        if($request->file('image') == '') {
            
            //update data tanpa image
            $facility = Facility::findOrFail($facility->id);
            $facility->update([
                'title'                 => $request->title,
                'slug'                  => Str::slug($request->title, '-'),
                'subtitle'           => $request->subtitle,
                'description'           => $request->description,
            ]);

        } else {

            //hapus image lama
            Storage::disk('local')->delete('public/facilities/'.basename($facility->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/facilities', $image->hashName());

            //update dengan image baru
            $facility = Facility::findOrFail($facility->id);
            $facility->update([
                'image'             => $image->hashName(),
                'title'              => $request->title,
                'slug'              => Str::slug($request->title, '-'),
                'subtitle'           => $request->subtitle,
                'description'           => $request->description,
            ]);
        }

        if($facility){
            //redirect dengan pesan sukses
            return redirect()->route('admin.facility.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.facility.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $facility = Facility::findOrFail($id);
        Storage::disk('local')->delete('public/facilities/'.basename($facility->image));
        $facility->delete();

        if($facility){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }

    public function massDestroy(Request $request)
    {
        $ids = $request->ids;

        $facilities = Facility::whereIn('id', $ids)->get();

        foreach ($facilities as $facility) {
            Storage::disk('local')->delete('public/facilities/' . $facility->image);
            $facility->delete();
        }

        return response()->json(['status' => 'success']);
    }
}
