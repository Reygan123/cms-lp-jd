<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Welcomechat;

class WelcomechatController extends Controller
{
    public function edit($id)
    {
        $welcomechat = Welcomechat::findOrfail($id);
        return view('admin.welcomechat.edit', compact('welcomechat'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
        ]); 

        
            //update data tanpa image
            $welcomechat = Welcomechat::findOrfail($id);
            $welcomechat->update([
                'greating'                   => $request->greating,
            ]);


        if($welcomechat){
            //redirect dengan pesan sukses
            return redirect()->route('admin.welcomechat.edit',$welcomechat->id)->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.welcomechat.edit',$welcomechat->id)->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
}
