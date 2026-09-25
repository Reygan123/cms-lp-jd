<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Ourteam;
use App\Models\Facility;
use App\Models\Dukungan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::latest()->when(request()->q, function ($programs) {
            $programs = $programs->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('admin.program.index', compact('programs'));
    }

    public function getHalamanPertama()
    {
        $ourteams = OurTeam::get()->sortBy('name');
        $facilities = Facility::all();
        return view('admin.program.create_halaman_pertama', compact('ourteams', 'facilities'));
    }

    public function postHalamanPertama(Request $request)
    {
        $this->validate($request, [
            'image1' => 'required|image|mimes:jpeg,jpg,png,webp|max:1000',
            'name' => 'required',
            'title1' => 'required',
            'description1' => 'required',
        ]);

        $image1 = $request->file('image1');
        $image1->storeAs('public/programs', $image1->hashName());

        $programData = [
            'image1' => $image1->hashName(),
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name'), '-'),
            'category' => $request->input('category'),
            'ourteam_id' => $request->input('ourteam_id'),
            'title1' => $request->input('title1'),
            'description1' => $request->input('description1'),
            'id_yt' => $request->input('id_yt'),
            'age' => $request->input('age'),
            'weekly' => $request->input('weekly'),
            'periode' => $request->input('periode'),
            'class_size' => $request->input('class_size'),
        ];

        $program = Program::create($programData);

        if ($program) {
            $program->facilities()->sync($request->input('facility_ids'));
            $request->session()->put('program_id', $program->id);
            return redirect()->route('admin.program.create.halaman-kedua')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            return redirect()->route('admin.program.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function getHalamanKedua()
    {
        $program = Program::find(session('program_id'));
        $dukungans = Dukungan::all();
        return view('admin.program.create_halaman_kedua', compact('program', 'dukungans'));
    }

    public function postHalamanKedua(Request $request)
    {
        $this->validate($request, [
            'image2' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:1000',
            'image3' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:1000',
        ]);

        $programData = [];

        if ($request->hasFile('image2')) {
            $image2 = $request->file('image2');
            $image2->storeAs('public/programs', $image2->hashName());
            $programData['image2'] = $image2->hashName();
        }

        if ($request->hasFile('image3')) {
            $image3 = $request->file('image3');
            $image3->storeAs('public/programs', $image3->hashName());
            $programData['image3'] = $image3->hashName();
        }

        $programData['title2'] = $request->input('title2');
        $programData['description2'] = $request->input('description2');
        $programData['title3'] = $request->input('title3');
        $programData['description3'] = $request->input('description3');

        $program = Program::find($request->session()->get('program_id'));
        $program->update($programData);

        if ($program) {
            $program->dukungans()->sync($request->input('dukungans', []));
            return redirect()->route('admin.program.create.halaman-ketiga')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            return redirect()->route('admin.program.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function getHalamanKetiga()
    {
        $program = Program::find(session('program_id'));
        return view('admin.program.create_halaman_ketiga', compact('program'));
    }

    public function postHalamanKetiga(Request $request)
    {
        $this->validate($request, [
            'image4' => 'nullable|image|mimes:jpeg,jpg,png|max:1000',
        ]);

        $programData = [];

        if ($request->hasFile('image4')) {
            $image4 = $request->file('image4');
            $image4->storeAs('public/programs', $image4->hashName());
            $programData['image4'] = $image4->hashName();
        }

        $programData = [
            'title4' => $request->input('title4'),
            'description4' => $request->input('description4'),
            'content' => $request->input('content'),
            'time_table' => $request->input('time_table'),
            'time_table2' => $request->input('time_table2'),
            'cta' => $request->input('cta'),
            'link_program' => $request->input('link_program'),
            'brosur' => $request->input('brosur'),
        ];

        $program = Program::find($request->session()->get('program_id'));
        $program->update($programData);

        if ($program) {
            return redirect()->route('admin.program.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            return redirect()->route('admin.program.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function editHalamanPertama(Program $program)
    {
        $ourteams = Ourteam::latest()->get();
        $facilities = Facility::all();
        return view('admin.program.edit_halaman_pertama', compact('program', 'ourteams', 'facilities'));
    }

    public function updateHalamanPertama(Request $request, Program $program)
    {
        $this->validate($request, [
            'image1' => 'image|mimes:jpeg,jpg,png,webp|max:1000',
            'name' => 'required',
            'title1' => 'required',
            'description1' => 'required',
        ]);

        if ($request->hasFile('image1')) {
            $this->validate($request, [
                'image1' => 'image|mimes:jpeg,jpg,png,webp|max:1000',
            ]);

            $image1 = $request->file('image1');
            $image1->storeAs('public/programs', $image1->hashName());
            $program->image1 = $image1->hashName();
        }

        // Update other fields for step one
        $program->name = $request->input('name');
        $program->slug = Str::slug($request->input('name'), '-');
        $program->category = $request->input('category');
        $program->title1 = $request->input('title1');
        $program->ourteam_id = $request->input('ourteam_id');
        $program->description1 = $request->input('description1');
        $program->id_yt = $request->input('id_yt');
        $program->age = $request->input('age');
        $program->weekly = $request->input('weekly');
        $program->periode = $request->input('periode');
        $program->class_size = $request->input('class_size');

        if ($program->save()) {
            $program->facilities()->sync($request->input('facility_ids')); // Tambahkan ini
            return redirect()->route('admin.program.edit.halaman-kedua', $program->id)->with(['success' => 'Data Halaman Pertama Berhasil Diupdate!']);
        } else {
            return redirect()->route('admin.program.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    public function editHalamanKedua(Program $program)
    {
        $dukungans = Dukungan::all();
        return view('admin.program.edit_halaman_kedua', compact('program', 'dukungans'));
    }

    public function updateHalamanKedua(Request $request, Program $program)
    {
        $this->validate($request, [
            'image2' => 'image|mimes:jpeg,jpg,png,webp|max:1000',
            'image3' => 'image|mimes:jpeg,jpg,png,webp|max:1000',
        ]);

        // Handle image2 update (if provided)
        if ($request->hasFile('image2')) {
            $image2 = $request->file('image2');
            $image2->storeAs('public/programs', $image2->hashName());
            $program->image2 = $image2->hashName();
        }

        // Handle image3 update (if provided)
        if ($request->hasFile('image3')) {
            $image3 = $request->file('image3');
            $image3->storeAs('public/programs', $image3->hashName());
            $program->image3 = $image3->hashName();
        }

        // Update other fields for step two
        $program->title2 = $request->input('title2');
        $program->description2 = $request->input('description2');
        $program->title3 = $request->input('title3');
        $program->description3 = $request->input('description3');

        // Sync dukungans
    $program->dukungans()->sync($request->input('dukungan_ids', []));

        if ($program->save()) {
            return redirect()->route('admin.program.edit.halaman-ketiga', $program->id)->with(['success' => 'Data Halaman Kedua Berhasil Diupdate!']);
        } else {
            return redirect()->route('admin.program.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    public function editHalamanKetiga(Program $program)
    {
        return view('admin.program.edit_halaman_ketiga', compact('program'));
    }

    public function updateHalamanKetiga(Request $request, Program $program)
    {
        $this->validate($request, [
            'image4' => 'image|mimes:jpeg,jpg,png|max:500',
        ]);

        // Handle image4 update (if provided)
        if ($request->hasFile('image4')) {
            $image4 = $request->file('image4');
            $image4->storeAs('public/programs', $image4->hashName());
            $program->image4 = $image4->hashName();
        }

        // Update other fields for step three
        $program->title4 = $request->input('title4');
        $program->description4 = $request->input('description4');
        $program->content = $request->input('content');
        $program->time_table = $request->input('time_table');
        $program->time_table2 = $request->input('time_table2');
        $program->cta = $request->input('cta');
        $program->link_program = $request->input('link_program');
        $program->brosur = $request->input('brosur');

        if ($program->save()) {
            return redirect()->route('admin.program.index')->with(['success' => 'Data Halaman Ketiga Berhasil Diupdate!']);
        } else {
            return redirect()->route('admin.program.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    public function destroy($id)
    {
        $program = Program::findOrFail($id);

        // Delete associated images
        Storage::disk('local')->delete('public/programs/' . basename($program->image1));
        Storage::disk('local')->delete('public/programs/' . basename($program->image2));
        Storage::disk('local')->delete('public/programs/' . basename($program->image3));
        Storage::disk('local')->delete('public/programs/' . basename($program->image4));

        // Delete the program record
        $program->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function massDestroy(Request $request)
    {
        $ids = $request->ids;

        $programs = Program::whereIn('id', $ids)->get();

        foreach ($programs as $program) {
            // Hapus gambar yang terkait
            Storage::disk('local')->delete('public/programs/' . $program->image1);
            Storage::disk('local')->delete('public/programs/' . $program->image2);
            Storage::disk('local')->delete('public/programs/' . $program->image3);
            Storage::disk('local')->delete('public/programs/' . $program->image4);

            // Hapus data program
            $program->delete();
        }

        return response()->json(['status' => 'success']);
    }

    public function deleteImage(Program $program, $image)
    {
        if (in_array($image, ['image2', 'image3', 'image4']) && $program->$image) {
            try {
                Storage::disk('local')->delete('public/programs/' . $program->$image);
                $program->$image = null;
                $program->save();
                return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
            } catch (\Exception $e) {
                // Log the error: \Log::error($e);
                return redirect()->back()->with('error', 'Gagal menghapus gambar.');
            }
        }
        return redirect()->route('admin.program.edit_halaman_kedua', $program->id)->with('success', 'Gambar berhasil dihapus.');
    }
}
