<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use App\Models\Visi;
use App\Models\Misi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AboutController extends Controller
{
    public function index()
    {
        $abouts = About::latest()->take(1)->get();
        $visis = Visi::latest()->take(1)->get();
        $misis = Misi::latest()->take(1)->get();

        return view('admin.about.index', compact('abouts','visis','misis'));
    }


    public function edit($id)
    {
        $about = About::findOrfail($id);
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request, About $about)
    {
        $this->validate($request, [
            'image1'  => 'image|mimes:jpeg,jpg,png,webp|max:1000',
            'image2'  => 'image|mimes:jpeg,jpg,png,webp|max:1000',
        ]);

        $images = [];

        DB::beginTransaction();

        try {
            // Hapus gambar lama jika ada
            if ($request->hasFile('image1') && $about->image1) {
                Storage::disk('public')->delete('identities/' . $about->image1);
            }
    
            if ($request->hasFile('image2') && $about->image2) {
                Storage::disk('public')->delete('identities/' . $about->image2);
            }
    
            // Upload gambar baru jika ada
            if ($request->hasFile('image1')) {
                $image1 = $request->file('image1');
                $image1_path = $image1->store('public/identities');
                $images['image1'] = basename($image1_path);
            }
    
            if ($request->hasFile('image2')) {
                $image2 = $request->file('image2');
                $image2_path = $image2->store('public/identities');
                $images['image2'] = basename($image2_path);
            }
    
            // Update data model
            $about->update([
            'image1'       => $images['image1'] ?? $about->image1,
            'image2'       => $images['image2'] ?? $about->image2,
            'title'                    => $request->title,
            'slug'              => Str::slug($request->title, '-'),
            'subtitle'                    => $request->subtitle,
            'description'                    => $request->description,
            'content'                    => $request->content,
            'video'                   => $request->video,
        ]);

        DB::commit(); // Commit transaksi jika semua berhasil

        return redirect()->route('admin.about.index')->with(['success' => 'Data Berhasil Diupdate!']);
    } catch (\Exception $e) {
        DB::rollBack(); // Rollback transaksi jika terjadi error
        Log::error('Error updating About: ' . $e->getMessage());

        return redirect()->route('admin.about.edit', $about->id)->with(['error' => 'Data Gagal Diupdate!']);
    }
    }

    public function deleteImage(About $about, $image)
    {
        if (in_array($image, ['image1', 'image2'])) {
            // Hapus gambar dari penyimpanan
            if ($about->$image) {
                Storage::disk('public')->delete('identities/' . $about->$image);
                $about->$image = null;
                $about->save();
            }
        }

        return redirect()->route('admin.about.edit', $about->id)->with('success', 'Gambar berhasil dihapus.');
    }
}
