<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Titlebenefit;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class TitlebenefitController extends Controller
{
    public function index()
    {
        $titlebenefits = Titlebenefit::oldest()->take(1)->get();

        return view('admin.titlebenefit.index', compact('titlebenefits'));
    }


    public function edit($id)
    {
        $titlebenefit = Titlebenefit::findOrfail($id);
        return view('admin.titlebenefit.edit', compact('titlebenefit'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'image'    => 'image|mimes:jpeg,jpg,png,webp|max:1000',
        ]);

        //check jika image kosong
        if($request->file('image') == '') {
        
            //update data tanpa image
            $titlebenefit = Titlebenefit::findOrfail($id);
            $titlebenefit->update([
                'title'                   => $request->title,
                'slug'                      => Str::slug($request->title, '-'),
                'description'                   => $request->description,
            ]);
        } else {
            $titlebenefit = Titlebenefit::findOrfail($id);

            //hapus image lama
            Storage::disk('local')->delete('public/benefits/'.basename($titlebenefit->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/benefits', $image->hashName());

             //update dengan image baru
             $titlebenefit = Titlebenefit::findOrfail($id);
             $titlebenefit->update([
                'image'                     => $image->hashName(),
                'title'                   => $request->title,
                'slug'                      => Str::slug($request->title, '-'),
                'description'                   => $request->description,
             ]);

        }

        if($titlebenefit){
            //redirect dengan pesan sukses
            return redirect()->route('admin.benefit.index',1)->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.titlebenefit.edit',1)->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    public function deleteImage(Titlebenefit $titlebenefit, $image)
    {
        if (in_array($image, ['image'])) {
            // Hapus gambar dari penyimpanan
            if ($titlebenefit->$image) {
                Storage::disk('public')->delete('benefits/' . $titlebenefit->$image);
                $titlebenefit->$image = null;
                $titlebenefit->save();
            }
        }

        return redirect()->route('admin.titlebenefit.edit', $titlebenefit->id)->with('success', 'Gambar berhasil dihapus.');
    }
}
