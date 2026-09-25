<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ganalytics;
use Illuminate\Support\Facades\DB;

class GanalyticsController extends Controller
{
    public function index()
    {
        $ganalytics = Ganalytics::oldest()->take(1)->get();

        return view('admin.ganalytics.index', compact('ganalytics'));
    }


    public function edit($id)
    {
        $ganalytics = Ganalytics::findOrfail($id);
        return view('admin.ganalytics.edit', compact('ganalytics'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
        ]); 

        
            //update data tanpa image
            $ganalytics = ganalytics::findOrfail($id);
            $ganalytics->update([
                'ganalytics_code'                   => $request->ganalytics_code,
            ]);


        if($ganalytics){
            //redirect dengan pesan sukses
            return redirect()->route('admin.ganalytics.edit',1)->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.ganalytics.edit',1)->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
}
