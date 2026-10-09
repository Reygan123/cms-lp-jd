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
        $partners = Partner::latest()
            ->when(request()->q, function($query) {
                $query->where('name', 'like', '%'. request()->q . '%');
            })
            ->when(request()->category, function($query) {
                $query->where('category', request()->category);
            })
            ->when(request()->level, function($query) {
                $query->where('level', request()->level);
            })
            ->paginate(10);

        $categories = Partner::CATEGORIES;
        $schoolLevels = Partner::SCHOOL_LEVELS;

        return view('admin.partner.index', compact('partners', 'categories', 'schoolLevels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Partner::CATEGORIES;
        $schoolLevels = Partner::SCHOOL_LEVELS;

        return view('admin.partner.create', compact('categories', 'schoolLevels'));
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
            'category'          => 'required|string|max:50',
            'level'             => 'nullable|string|max:50',
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/partners', $image->hashName());

        $partner = Partner::create([
            'name'              => $request->name,
            'slug'              => Str::slug($request->name, '-'),
            'category'          => $request->category ?? 'sekolah',
            'level'             => $request->level,
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
     * @param  Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Partner $partner)
    {
        $categories = Partner::CATEGORIES;
        $schoolLevels = Partner::SCHOOL_LEVELS;

        return view('admin.partner.edit', compact('partner', 'categories', 'schoolLevels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partner $partner)
    {
        $this->validate($request, [
            'name'              => 'required',
            'category'          => 'required|string|max:50',
            'level'             => 'nullable|string|max:50',
        ]); 

        //check jika image kosong
        if($request->file('image') == '') {
            
            //update data tanpa image
            $partner = Partner::findOrFail($partner->id);
            $partner->update([
                'name'              => $request->name,
                'slug'              => Str::slug($request->name, '-'),
                'category'          => $request->category ?? 'sekolah',
                'level'             => $request->level,
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
            $partner = Partner::findOrFail($partner->id);
            $partner->update([
                'name'              => $request->name,
                'slug'              => Str::slug($request->name, '-'),
                'category'          => $request->category ?? 'sekolah',
                'level'             => $request->level,
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
        $partner = Partner::findOrFail($id);
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
