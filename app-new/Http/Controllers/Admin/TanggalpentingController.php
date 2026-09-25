<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tanggalpenting;

class TanggalpentingController extends Controller
{
    public function index()
    {
        $tanggalpentings = Tanggalpenting::latest()->when(request()->q, function($tanggalpentings) {
            $tanggalpentings = $tanggalpentings->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);
        return view('admin.tanggalpenting.index', compact('tanggalpentings'));
    }

    public function create()
    {
        return view('admin.tanggalpenting.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'date'  => 'required',
            'title'  => 'required',
        ]);

        //save to DB
        $tanggalpenting = Tanggalpenting::create([
            'date'        => $request->date,
            'title'       => $request->title,
            'description' => $request->description,
        ]);

        return $tanggalpenting
            ? redirect()->route('admin.tanggalpenting.index')->with(['success' => 'Data Berhasil Disimpan!'])
            : redirect()->route('admin.tanggalpenting.index')->with(['error' => 'Data Gagal Disimpan!']);
    }

    public function edit(Tanggalpenting $tanggalpenting)
    {
        return view('admin.tanggalpenting.edit', compact('tanggalpenting'));
    }

    public function update(Request $request, Tanggalpenting $tanggalpenting)
    {
        $this->validate($request, [
            'date'  => 'required',
            'title'  => 'required',
        ]);

        $tanggalpenting->update([
            'date'        => $request->date,
            'title'       => $request->title,
            'description' => $request->description,
        ]);

        return $tanggalpenting
            ? redirect()->route('admin.tanggalpenting.index')->with(['success' => 'Data Berhasil Diupdate!'])
            : redirect()->route('admin.tanggalpenting.index')->with(['error' => 'Data Gagal Diupdate!']);
    }

    public function destroy($id)
    {
        $tanggalpenting = Tanggalpenting::findOrFail($id);
        $tanggalpenting->delete();

        return $tanggalpenting
            ? response()->json(['status' => 'success'])
            : response()->json(['status' => 'error']);
    }

    public function massDestroy(Request $request)
    {
        $ids = $request->ids;

        $tanggalpentings = Tanggalpenting::whereIn('id', $ids)->get();

        foreach ($tanggalpentings as $tanggalpenting) {
            $tanggalpenting->delete();
        }

        return response()->json(['status' => 'success']);
    }
}
