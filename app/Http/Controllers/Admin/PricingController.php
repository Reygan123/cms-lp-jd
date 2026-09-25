<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Pricing;
use App\Models\Program;
use Illuminate\Support\Str;

class PricingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pricings = Pricing::latest()->when(request()->q, function ($pricings) {
            $pricings = $pricings->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('admin.pricing.index', compact('pricings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $programs = Program::latest()->get();
        return view('admin.pricing.create', compact('programs'));
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
            'title'                 => 'required',
            'price'                 => 'required',
        ]);


        //save to DB
        $pricing = Pricing::create([
            'title'                     => $request->title,
            'slug'                      => Str::slug($request->title, '-'),
            'program_id'                => $request->program_id,
            'description'               => $request->description,
            'price'                      => $request->price,
            'diskon'                      => $request->diskon,
        ]);

        if ($pricing) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.pricing.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('admin.pricing.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pricing $pricing)
    {
        $programs = Program::latest()->get();
        return view('admin.pricing.edit', compact('pricing'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pricing $pricing)
    {
        $this->validate($request, [
            'title'                 => 'required',
            'price'                 => 'required',
        ]);

       
            $pricing = Pricing::findOrFail($pricing->id);
            $pricing->update([
               'title'                     => $request->title,
                'slug'                      => Str::slug($request->title, '-'),
                'program_id'                => $request->program_id,
                'description'               => $request->description,
                'price'                      => $request->price,
                'diskon'                      => $request->diskon,

            ]);
        

        if ($pricing) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.pricing.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('admin.pricing.index')->with(['error' => 'Data Gagal Diupdate!']);
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
        $pricing = Pricing::findOrFail($id);
        $pricing->delete();

        if ($pricing) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }

    public function massDestroy(Request $request)
    {
        $ids = $request->ids;

        $pricings = Pricing::whereIn('id', $ids)->get();

        foreach ($pricings as $pricing) {
            $pricing->delete();
        }

        return response()->json(['status' => 'success']);
    }
}
