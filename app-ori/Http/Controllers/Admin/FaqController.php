<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::oldest()->when(request()->q, function($faq) {
            $faq = $faq->where('name', 'like', '%'. request()->q . '%');
        })->paginate(15);
        return view('admin.faq.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faq.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title'  => 'required',
            'description'  => 'required'
        ]);
        $faq = Faq::create([
            'title'             => $request->title,
            'description'       => $request->description,

        ]);
 
        if($faq){
            //redirect dengan pesan sukses
            return redirect()->route('admin.faq.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.faq.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }
    public function edit(Faq $faq)
     {
         return view('admin.faq.edit', compact('faq'));
     }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'         => 'required',
            'description'         => 'required',
        ]); 

        //update data tanpa image
        $faq = Faq::findOrfail($id);
        $faq->update([
            'title'                   => $request->title,
            'description'            => $request->description,

        ]);
        

        if($faq){
            //redirect dengan pesan sukses
            return redirect()->route('admin.faq.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.faq.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        if($faq){
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

        $faqs = faq::whereIn('id', $ids)->get();

        foreach ($faqs as $faq) {
            $faq->delete();
        }

        return response()->json(['status' => 'success']);
    }

}
