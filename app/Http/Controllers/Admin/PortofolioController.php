<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Portofolio;
use App\Models\Program;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PortofolioController extends Controller
{
    public function index()
    {
        $portofolios = Portofolio::latest()->when(request()->q, function ($portofolios) {
            $portofolios = $portofolios->where('title', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('admin.portofolio.index', compact('portofolios'));
    }

    public function create()
    {
        $programs = Program::latest()->get();
        return view('admin.portofolio.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image1'            => 'image|mimes:jpeg,jpg,png,webp|max:1000',
            'image2'            => 'image|mimes:jpeg,jpg,png,webp|max:1000',
            'image3'            => 'image|mimes:jpeg,jpg,png,webp|max:1000',
            'image4'            => 'image|mimes:jpeg,jpg,png,webp|max:1000',
            'logo'              => 'image|mimes:jpeg,jpg,png,webp|max:500',
            'title'             => 'required',
        ]);

        $data = [
            'title'             => $request->title,
            'slug'              => Str::slug($request->title, '-'),
            'description'       => $request->description,
            'program_id'        => $request->program_id,
            'home'              => $request->home,
            'yt_id' => $request->yt_id,
        ];

        // Handle image1 upload
        if ($request->hasFile('image1')) {
            $image1 = $request->file('image1');
            $path = $image1->storeAs('public/portofolios', $image1->hashName());
            $data['image1'] = basename($path);  // Only save the filename
        }

        // Handle image2 upload
        if ($request->hasFile('image2')) {
            $image2 = $request->file('image2');
            $path = $image2->storeAs('public/portofolios', $image2->hashName());
            $data['image2'] = basename($path);  // Only save the filename
        }

        // Handle image3 upload
        if ($request->hasFile('image3')) {
            $image3 = $request->file('image3');
            $path = $image3->storeAs('public/portofolios', $image3->hashName());
            $data['image3'] = basename($path);  // Only save the filename
        }

        // Handle image4 upload
        if ($request->hasFile('image4')) {
            $image4 = $request->file('image4');
            $path = $image4->storeAs('public/portofolios', $image4->hashName());
            $data['image4'] = basename($path);  // Only save the filename
        }
        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $path = $logo->storeAs('public/portofolios', $logo->hashName());
            $data['logo'] = basename($path);  // Only save the filename
        }
        $portofolio = Portofolio::create($data);

        if ($portofolio) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.portofolio.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('admin.portofolio.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function edit(Portofolio $portofolio)
    {
        $programs = Program::latest()->get();
        return view('admin.portofolio.edit', compact('portofolio', 'programs'));
    }

    public function update(Request $request, Portofolio $portofolio)
{
    $this->validate($request, [
        'title' => 'required',
        'image1' => 'image|mimes:jpeg,jpg,png,webp,svg|max:1000',
        'image2' => 'image|mimes:jpeg,jpg,png,webp,svg|max:1000',
        'image3' => 'image|mimes:jpeg,jpg,png,webp,svg|max:1000',
        'image4' => 'image|mimes:jpeg,jpg,png,webp,svg|max:1000',
        'logo'  => 'image|mimes:jpeg,jpg,png,webp,svg|max:5000',
    ]);

    $images = [];

    if ($request->hasFile('image1')) {
        if (!is_null($portofolio->image1)) {
            Storage::disk('public')->delete('portofolios/' . $portofolio->image1);
        }
        $image = $request->file('image1');
        $image_path = $image->store('public/portofolios');
        $images['image1'] = basename($image_path);
    }

    if ($request->hasFile('image2')) {
        if (!is_null($portofolio->image2)) {
            Storage::disk('public')->delete('portofolios/' . $portofolio->image2);
        }
        $image = $request->file('image2');
        $image_path = $image->store('public/portofolios');
        $images['image2'] = basename($image_path);
    }

    if ($request->hasFile('image3')) {
        if (!is_null($portofolio->image3)) {
            Storage::disk('public')->delete('portofolios/' . $portofolio->image3);
        }
        $image = $request->file('image3');
        $image_path = $image->store('public/portofolios');
        $images['image3'] = basename($image_path);
    }

    if ($request->hasFile('image4')) {
        if (!is_null($portofolio->image4)) {
            Storage::disk('public')->delete('portofolios/' . $portofolio->image4);
        }
        $image = $request->file('image4');
        $image_path = $image->store('public/portofolios');
        $images['image4'] = basename($image_path);
    }
    if ($request->hasFile('logo')) {
        if (!is_null($portofolio->logo)) {
            Storage::disk('public')->delete('portofolios/' . $portofolio->logo);
        }
        $image = $request->file('logo');
        $image_path = $image->store('public/portofolios');
        $images['logo'] = basename($image_path);
    }

    $portofolio->update([
        'title' => $request->title,
        'slug' => Str::slug($request->title, '-'),
        'description' => $request->description,
        'program_id' => $request->program_id,
        'home' => $request->home,
        'yt_id' => $request->yt_id,
        'image1' => $images['image1'] ?? $portofolio->image1,
        'image2' => $images['image2'] ?? $portofolio->image2,
        'image3' => $images['image3'] ?? $portofolio->image3,
        'image4' => $images['image4'] ?? $portofolio->image4,
        'logo' => $images['logo'] ?? $portofolio->logo,
    ]);

    if ($portofolio) {
        return redirect()->route('admin.portofolio.index')->with(['success' => 'Data Berhasil Diupdate!']);
    } else {
        return redirect()->route('admin.portofolio.index')->with(['error' => 'Data Gagal Diupdate!']);
    }
}


    public function deleteImage(Portofolio $portofolio, $image)
    {
        if (in_array($image, ['image1', 'image2', 'image3', 'image4','logo'])) {
            // Hapus gambar dari penyimpanan
            if ($portofolio->$image) {
                Storage::disk('public')->delete('portofolios/' . $portofolio->$image);
                $portofolio->$image = null;
                $portofolio->save();
            }
        }

        return redirect()->route('admin.portofolio.edit', $portofolio->id)->with('success', 'Gambar berhasil dihapus.');
    }

    public function show($slug)
    {
        $portofolio = Portofolio::where('slug', $slug)->first();

        return view('admin.portofolio.show', compact('portofolio'));
    }

    public function massDestroy(Request $request)
    {
        $ids = $request->ids;

        $portofolios = Portofolio::whereIn('id', $ids)->get();

        foreach ($portofolios as $portofolio) {
            // Delete image1 if it exists
            if ($portofolio->image1) {
                Storage::disk('local')->delete('public/portofolios/' . $portofolio->image1);
            }

            // Delete image2 if it exists
            if ($portofolio->image2) {
                Storage::disk('local')->delete('public/portofolios/' . $portofolio->image2);
            }

            // Delete image3 if it exists
            if ($portofolio->image3) {
                Storage::disk('local')->delete('public/portofolios/' . $portofolio->image3);
            }

            // Delete image4 if it exists
            if ($portofolio->image4) {
                Storage::disk('local')->delete('public/portofolios/' . $portofolio->image4);
            }

            // Delete image4 if it exists
            if ($portofolio->logo) {
                Storage::disk('local')->delete('public/portofolios/' . $portofolio->logo);
            }

            $portofolio->delete();
        }

        return response()->json(['status' => 'success']);
    }
}
