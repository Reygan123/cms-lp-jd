<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sambutan;
use Illuminate\Support\Str; 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SambutanController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $sambutans = Sambutan::latest()->take(1)->get();

        return view('admin.sambutan.index', compact('sambutans'));
    }

    /**
     * edit
     *
     * @param  mixed $request
     * @param  mixed $sambutan
     * @return void
     */
    public function edit(Sambutan $sambutan)
    {
        return view('admin.sambutan.edit', compact('sambutan'));
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $sambutan
     * @return void
     */
    public function update(Request $request, Sambutan $sambutan)
    {
        $this->validate($request, [
            'image'                 => 'nullable|image|mimes:jpeg,jpg,png|max:500',
            'title'                 => 'required',
            'name'                  => 'required',
            'description'           => 'required',
        ]); 
        
        //check if image is not present
        if (!$request->hasFile('image')) {
            
            //update data without image
            $sambutan->update([
                'name'                  => $request->name,
                'slug'                  => Str::slug($request->title, '-'),
                'title'                 => $request->title,
                'description'           => $request->description,
                'video'                 => $request->video,
            ]);
        } else {
            //delete old image
            Storage::disk('local')->delete('public/identities/'.basename($sambutan->image));

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/identities', $image->hashName());

            //update with new image
            $sambutan->update([
                'image'                => $image->hashName(),
                'name'                 => $request->name,
                'slug'                  => Str::slug($request->title, '-'),
                'title'                => $request->title,
                'description'          => $request->description,
                'video'                => $request->video,
            ]);
        }

        if ($sambutan) {
            //redirect with success message
            return redirect()->route('admin.sambutan.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            //redirect with error message
            return redirect()->route('admin.sambutan.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
}
