<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Svg;

class SvgController extends Controller
{
    public function index()
    {
        $svg = Svg::all();
        return view('admin.svg.index', compact('svg'));
    }

    public function edit($id)
    {
        $svg = Svg::findOrfail($id);
        return view('admin.svg.edit', compact('svg'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title1'             => 'required',
            'title2'             => 'required',
            'title3'             => 'required',
            'data1'             => 'required',
            'data2'             => 'required',
            'data3'             => 'required',
        ]);


        //update data tanpa image
        $svg = Svg::findOrfail($id);
        $svg->update([
            'title1'                    => $request->title1,
            'title2'                    => $request->title2,
            'title3'                    => $request->title3,
            'title4'                    => $request->title4,
            'data1'                    => $request->data1,
            'data2'                    => $request->data2,
            'data3'                    => $request->data3,
            'data4'                    => $request->data4,
            'value1'                    => $request->value1,
            'value2'                    => $request->value2,
            'value3'                    => $request->value3,
            'value4'                    => $request->value4,
            'value5'                    => $request->value5,
            'value6'                    => $request->value6,
        ]);



        if ($svg) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.svg.edit',$svg->id)->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('admin.svg.index',$svg->id)->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
}
