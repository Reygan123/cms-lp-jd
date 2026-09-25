<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\Benefit;
use App\Models\Facility;
use App\Models\Program;
use App\Models\Titlebenefit;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BenefitController extends Controller
{

    public function index()
    {
        $benefits = Benefit::latest()->when(request()->q, function($benefits) {
            $benefits = $benefits->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);

        $titles = Titlebenefit::latest()->take(1)->get();
        

        return view('admin.benefit.index', compact('benefits','titles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $facilities = Facility::latest()->get();
        return view('admin.benefit.create',compact('facilities'));
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
            'title'             => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,webp|max:1000',
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/benefits', $image->hashName());

        $benefit = Benefit::create([
                'image'                => $image->hashName(),
                'title'                   => $request->title,
                'slug'                   => Str::slug($request->title, '-'),
                'description'            => $request->description,
                'facility_id'                => $request->facility_id,
                'home'             => $request->home,
        ]);
 
        if($benefit){
            //redirect dengan pesan sukses
            return redirect()->route('admin.benefit.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.benefit.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function edit($id)
    {
        $benefit = Benefit::findOrfail($id);
        $facilities = Facility::latest()->get();
        return view('admin.benefit.edit', compact('benefit','facilities'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'         => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,webp|max:1000',
        ]); 

        //check jika image kosong
        if($request->file('image') == '') {
            
            //update data tanpa image
            $benefit = Benefit::findOrfail($id);
            $benefit->update([
                'title'                   => $request->title,
                'slug'                   => Str::slug($request->title, '-'),
                'description'            => $request->description,
                'facility_id'                => $request->facility_id,
                'home'             => $request->home,
            ]);

        } else {
            $benefit = Benefit::findOrfail($id);
            //hapus image lama
            Storage::disk('local')->delete('public/benefits/'.basename($benefit->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/benefits', $image->hashName());

            //update dengan image baru
            $benefit = Benefit::findOrfail($id);
            $benefit->update([
                'image'                => $image->hashName(),
                'title'                   => $request->title,
                'slug'                   => Str::slug($request->title, '-'),
                'description'            => $request->description,
                'facility_id'                => $request->facility_id,
                'home'             => $request->home,
            ]);
        }

        if($benefit){
            //redirect dengan pesan sukses
            return redirect()->route('admin.benefit.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.benefit.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    /**
     * destroy 
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $benefit = Benefit::findOrFail($id);
        Storage::disk('local')->delete('public/benefits/'.basename($benefit->image));
        $benefit->delete();

        if($benefit){
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
