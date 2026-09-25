<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Story;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class StoryController extends Controller
{
    public function index()
    {
        $stories = Story::latest()->when(request()->q, function($stories) {
            $stories = $stories->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);

        
        return view('admin.story.index', compact('stories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.story.create');
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
            'image'             => 'required|image|mimes:jpeg,jpg,png|max:1000',
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/stories', $image->hashName());

        $story = Story::create([
            'title'             => $request->title,
            'slug'              => Str::slug($request->title, '-'),
            'description'       => $request->description,
            'year'             => $request->year,
            'image'             => $image->hashName()
        ]);
 
        if($story){
            //redirect dengan pesan sukses
            return redirect()->route('admin.story.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.story.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function edit($id)
    {
        $story = Story::findOrfail($id);
        return view('admin.story.edit', compact('story'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'image'             => 'image|mimes:jpeg,jpg,png|max:1000',
        ]); 

        //check jika image kosong
        if($request->file('image') == '') {
            
            //update data tanpa image
            $story = Story::findOrfail($id);
            $story->update([
                'title'             => $request->title,
                'slug'              => Str::slug($request->title, '-'),
                'description'       => $request->description,
                'year'             => $request->year,
                
            ]);

        } else {
            $story = Story::findOrfail($id);
            //hapus image lama
            Storage::disk('local')->delete('public/stories/'.basename($story->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/stories', $image->hashName());

            //update dengan image baru
            $story = story::findOrfail($id);
            $story->update([
                'title'             => $request->title,
                'slug'              => Str::slug($request->title, '-'),
                'description'       => $request->description,
                'year'             => $request->year,
                'image'             => $image->hashName()
            ]);
        }

        if($story){
            //redirect dengan pesan sukses
            return redirect()->route('admin.story.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.story.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    public function destroy($id)
    {
        $story = Story::findOrFail($id);
        Storage::disk('local')->delete('public/stories/'.basename($story->image));
        $story->delete();

        if($story){
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
