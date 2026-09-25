<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Impact;

class ImpactController extends Controller
{
    public function index()
    {
        $impact = Impact::all();
        return view('admin.impact.index', compact('impact'));
    }

    public function edit($id)
    {
        $impact = Impact::findOrfail($id);
        return view('admin.impact.edit', compact('impact'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title1'         => 'required',
        ]); 
        $impact = Impact::findOrfail($id);
            $impact->update([
                'title1'               => $request->title1,
                'number1'              => $request->number1,
                'title2'               => $request->title2,
                'number2'              => $request->number2,
                'title3'               => $request->title3,
                'number3'              => $request->number3,
                'title4'               => $request->title4,
                'number4'              => $request->number4,    
            ]);

            if($impact){
                //redirect dengan pesan sukses
                return redirect()->route('admin.impact.index')->with(['success' => 'Data Berhasil Diupdate!']);
            }else{
                //redirect dengan pesan error
                return redirect()->route('admin.impact.index')->with(['error' => 'Data Gagal Diupdate!']);
            }
    }
}
