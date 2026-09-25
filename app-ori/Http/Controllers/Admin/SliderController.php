<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Program;

 
class SliderController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $sliders = Slider::latest()->paginate(5);
        return view('admin.slider.index', compact('sliders'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $programs = Program::latest()->get();
        return view('admin.slider.create', compact('programs'));
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'         => 'required', 
            'image'         => 'required|image|mimes:jpeg,jpg,png,webp|max:1280',
        ]); 
 
        //upload image
        $image = $request->file('image');
        $image->storeAs('public/sliders', $image->hashName());
 
        //save to DB
        $slider = Slider::create([
            'title'             => $request->title,
            'slug'              => Str::slug($request->title, '-'),
            'image'             => $image->hashName(),
            'description'       => $request->description,
            'button'            => $request->button,
            'link'              => $request->link,
            'align'             => $request->align,
            'program_id'             => $request->program_id,
            'home'             => $request->home,
            'yt_id'             => $request->yt_id,
        ]);
 
        if($slider){
             //redirect dengan pesan sukses
             return redirect()->route('admin.slider.index')->with(['success' => 'Data Berhasil Disimpan!']);
         }else{
             //redirect dengan pesan error
             return redirect()->route('admin.slider.index')->with(['error' => 'Data Gagal Disimpan!']);
         }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        $programs = Program::latest()->get();
        return view('admin.slider.edit', compact('slider','programs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        $this->validate($request, [
            'title'         => 'required', 
            'image'                 => 'nullable|image|mimes:jpeg,jpg,png,webp|max:1280',
        ]); 

        //check jika image kosong
        if($request->file('image') == '') {
            
            //update data tanpa image
            $slider = Slider::findOrFail($slider->id);
            $slider->update([
                'title'             => $request->title,
                'slug'              => Str::slug($request->title, '-'),
                'description'       => $request->description,
                'button'            => $request->button,
                'link'              => $request->link,
                'align'             => $request->align,
                'program_id'             => $request->program_id,
                'home'             => $request->home,
                'yt_id'             => $request->yt_id,
            ]);

        } else {

            //hapus image lama
            Storage::disk('local')->delete('public/sliders/'.basename($slider->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/sliders', $image->hashName());

            //update dengan image baru
            $slider = Slider::findOrFail($slider->id);
            $slider->update([
                'title'             => $request->title,
                'slug'              => Str::slug($request->title, '-'),
                'image'             => $image->hashName(),
                'description'       => $request->description,
                'button'            => $request->button,
                'link'              => $request->link,
                'align'             => $request->align,
                'program_id'             => $request->program_id,
                'home'             => $request->home,
                'yt_id'             => $request->yt_id,
            ]);
        }

        if($slider){
            //redirect dengan pesan sukses
            return redirect()->route('admin.slider.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.slider.index')->with(['error' => 'Data Gagal Diupdate!']);
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
        $slider = Slider::findOrFail($id);
        Storage::disk('local')->delete('public/sliders/'.basename($slider->image));
        $slider->delete();

        if($slider){
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

        $sliders = Slider::whereIn('id', $ids)->get();

        foreach ($sliders as $slider) {
            Storage::disk('local')->delete('public/sliders/' . $slider->image);
            $slider->delete();
        }

        return response()->json(['status' => 'success']);
    }
}