<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Partner;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partners = Partner::oldest()->when(request()->q, function($partners) {
            $partners = $partners->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.partner.index', compact('partners'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.partner.create');
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
            'image'             => 'required|image|mimes:jpeg,jpg,png|max:750',
            'name'              => 'required',
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/partners', $image->hashName());

        $partner = partner::create([
            'name'              => $request->name,
            'slug'              => Str::slug($request->name, '-'),
            'description'       => $request->description,
            'program_desc'      => $request->program_desc,
            'web'               => $request->web,
            'image'             => $image->hashName()
        ]);
 
        if($partner){
            //redirect dengan pesan sukses
            return redirect()->route('admin.partner.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.partner.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(partner $partner)
    {
        return view('admin.partner.edit', compact('partner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, partner $partner)
    {
        $this->validate($request, [
            'name'              => 'required',
        ]); 

        //check jika image kosong
        if($request->file('image') == '') {
            
            //update data tanpa image
            $partner = partner::findOrFail($partner->id);
            $partner->update([
                'name'              => $request->name,
                'slug'              => Str::slug($request->name, '-'),
                'description'       => $request->description,
                'program_desc'      => $request->program_desc,
                'web'               => $request->web,
            ]);

        } else {

            //hapus image lama
            Storage::disk('local')->delete('public/partners/'.basename($partner->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/partners', $image->hashName());

            //update dengan image baru
            $partner = partner::findOrFail($partner->id);
            $partner->update([
                'name'              => $request->name,
                'slug'              => Str::slug($request->title, '-'),
                'description'       => $request->description,
                'program_desc'      => $request->program_desc,
                'web'               => $request->web,
                'image'             => $image->hashName()
            ]);
        }

        if($partner){
            //redirect dengan pesan sukses
            return redirect()->route('admin.partner.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.partner.index')->with(['error' => 'Data Gagal Diupdate!']);
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
        $partner = partner::findOrFail($id);
        Storage::disk('local')->delete('public/partners/'.basename($partner->image));
        $partner->delete();

        if($partner){
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
