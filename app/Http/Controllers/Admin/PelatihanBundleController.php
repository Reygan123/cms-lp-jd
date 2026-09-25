<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use App\Models\PelatihanBundle;
use Illuminate\Http\Request;

class PelatihanBundleController extends Controller
{
    public function index($pelatihanId)
    {
        $pelatihan = Pelatihan::findOrFail($pelatihanId);
        $bundles   = PelatihanBundle::where('pelatihan_id', $pelatihanId)->orderBy('person_count')->get();
        return view('admin.pelatihan.bundle.index', compact('pelatihan', 'bundles'));
    }

    public function create($pelatihanId)
    {
        $pelatihan = Pelatihan::findOrFail($pelatihanId);
        return view('admin.pelatihan.bundle.create', compact('pelatihan'));
    }

    public function store(Request $request, $pelatihanId)
    {
        $this->validate($request, [
            'name'         => 'required|string|max:100',
            'person_count' => 'required|integer|min:1',
            'bundle_price' => 'required|numeric|min:0',
            'description'  => 'nullable|string|max:255',
        ]);

        PelatihanBundle::create([
            'pelatihan_id' => $pelatihanId,
            'name'         => $request->name,
            'person_count' => $request->person_count,
            'bundle_price' => $request->bundle_price,
            'description'  => $request->description,
            'is_active'    => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.pelatihan.bundle.index', $pelatihanId)
            ->with(['success' => 'Paket bundling berhasil ditambahkan!']);
    }

    public function edit($pelatihanId, $bundleId)
    {
        $pelatihan = Pelatihan::findOrFail($pelatihanId);
        $bundle    = PelatihanBundle::where('pelatihan_id', $pelatihanId)->findOrFail($bundleId);
        return view('admin.pelatihan.bundle.edit', compact('pelatihan', 'bundle'));
    }

    public function update(Request $request, $pelatihanId, $bundleId)
    {
        $this->validate($request, [
            'name'         => 'required|string|max:100',
            'person_count' => 'required|integer|min:1',
            'bundle_price' => 'required|numeric|min:0',
            'description'  => 'nullable|string|max:255',
        ]);

        $bundle = PelatihanBundle::where('pelatihan_id', $pelatihanId)->findOrFail($bundleId);
        $bundle->update([
            'name'         => $request->name,
            'person_count' => $request->person_count,
            'bundle_price' => $request->bundle_price,
            'description'  => $request->description,
            'is_active'    => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.pelatihan.bundle.index', $pelatihanId)
            ->with(['success' => 'Paket bundling berhasil diperbarui!']);
    }

    public function destroy($pelatihanId, $bundleId)
    {
        $bundle = PelatihanBundle::where('pelatihan_id', $pelatihanId)->findOrFail($bundleId);
        $bundle->delete();
        return redirect()->route('admin.pelatihan.bundle.index', $pelatihanId)
            ->with(['success' => 'Paket bundling berhasil dihapus!']);
    }
}
