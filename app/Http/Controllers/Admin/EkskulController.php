<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Ekskul;
use Illuminate\Support\Str;

class EkskulController extends Controller
{
    public function index()
    {
        $ekskuls = Ekskul::latest()->when(request()->q, function($ekskuls) {
            $ekskuls = $ekskuls->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.ekskul.index', compact('ekskuls'));
    }

    public function create()
    {
        return view('admin.ekskul.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image'     => 'image|mimes:jpeg,jpg,png,webp|max:1000',
            'logo'      => 'image|mimes:jpeg,jpg,png,webp|max:300',
            'name'      => 'required'
        ]);

        // upload image
        $image = $request->file('image');
        $image->storeAs('public/ekskuls', $image->hashName());

        // upload logo
        $logo = $request->file('logo');
        $logo->storeAs('public/ekskuls', $logo->hashName());

        $ekskul = Ekskul::create([
            'name'              => $request->name,
            'slug'              => Str::slug($request->name, '-'),
            'description'       => $request->description,
            'image'             => $image->hashName(),
            'logo'              => $logo->hashName(),
        ]);
 
        if($ekskul){
            //redirect dengan pesan sukses
            return redirect()->route('admin.ekskul.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.ekskul.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }
    public function edit(Ekskul $ekskul)
    {
        return view('admin.ekskul.edit', compact('ekskul'));
    }
    public function update(Request $request, Ekskul $ekskul){
        $this->validate($request, [
            'name' => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,webp|max:1000',
            'logo' => 'image|mimes:jpeg,jpg,png,webp|max:300',
        ]);
    
        $images = [];
    
        // Check if any image has been uploaded
        if($request->hasFile('image')) {
            // Delete old image
            if(!is_null($ekskul->image)) {
                Storage::disk('public')->delete($ekskul->image);
            }
    
            // Upload new image
            $image = $request->file('image');
            $image_path = $image->store('public/ekskuls');
            $images['image'] = basename($image_path);
        }
    
        if($request->hasFile('logo')) {
            // Delete old image
            if(!is_null($ekskul->logo)) {
                Storage::disk('public')->delete($ekskul->logo);
            }
    
            // Upload new image
            $logo = $request->file('logo');
            $logo_path = $logo->store('public/ekskuls');
            $images['logo'] = basename($logo_path);
        }
    
        // Update other fields
        $ekskul->update([
            'name'              => $request->name,
            'slug'              => Str::slug($request->name, '-'),
            'description'       => $request->description,
            'image'             => $images['image'] ?? $ekskul->image,
            'logo'              => $images['logo'] ?? $ekskul->logo,
        ]);
    
        if($ekskul){
            //redirect dengan pesan sukses
            return redirect()->route('admin.ekskul.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.ekskul.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    
    public function show($slug)
    {
        $ekskul = Ekskul::where('slug', $slug)->first();

        return view('admin.ekskul.show', compact('ekskul'));
    }

    public function destroy($id)
    {
        $ekskul = Ekskul::findOrFail($id);

        if (Storage::disk('public')->exists('ekskuls/' . basename($ekskul->image))) {
            Storage::disk('public')->delete('ekskuls/' . basename($ekskul->image));
        }

        if (Storage::disk('public')->exists('ekskuls/' . basename($ekskul->logo))) {
            Storage::disk('public')->delete('ekskuls/' . basename($ekskul->logo));
        }

        $ekskul->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }

}


