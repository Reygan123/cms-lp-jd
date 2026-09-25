<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statistik;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statistiks = Statistik::latest()->paginate(10);
        return view('admin.statistik.index', compact('statistiks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.statistik.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pengguna' => 'required|integer',
            'assesmen' => 'required|integer',
            'psikologi' => 'required|integer',
            'konselor' => 'required|integer',
        ]);

        Statistik::create($validated);

        return redirect()->route('admin.statistik.index')->with('success', 'Statistik created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Statistik $statistik)
    {
        return view('admin.statistik.show', compact('statistik'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Statistik $statistik)
    {
        return view('admin.statistik.edit', compact('statistik'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Statistik $statistik)
    {
        $validated = $request->validate([
            'pengguna' => 'required|integer',
            'assesmen' => 'required|integer',
            'psikologi' => 'required|integer',
            'konselor' => 'required|integer',
        ]);

        $statistik->update($validated);

        return redirect()->route('admin.statistik.index')->with('success', 'Statistik updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Statistik $statistik)
    {
        $statistik->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Remove multiple resources from storage.
     */
    public function massDestroy(Request $request)
    {
        $ids = $request->ids;
        Statistik::whereIn('id', $ids)->delete();

        return response()->json(['status' => 'success']);
    }
}
