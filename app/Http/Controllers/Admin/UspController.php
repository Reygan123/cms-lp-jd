<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UspController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Usp::query();

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $usps = $query->latest()->paginate(10);

        return view('admin.usp.index', compact('usps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.usp.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/usps', $filename);
            $validated['image'] = $filename;
        }

        Usp::create($validated);

        return redirect()->route('admin.usp.index')->with('success', 'USP created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Usp $usp)
    {
        return view('admin.usp.show', compact('usp'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usp $usp)
    {
        return view('admin.usp.edit', compact('usp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usp $usp)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Update image if new one is uploaded
        if ($request->hasFile('image')) {
            // Delete old image
            if ($usp->image) {
                Storage::delete('public/usps/' . $usp->image);
            }

            // Upload new image
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/usps', $filename);
            $validated['image'] = $filename;
        } else {
            $validated['image'] = $usp->image;
        }

        $usp->update($validated);

        return redirect()->route('admin.usp.index')->with('success', 'USP updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $usp = Usp::findOrFail($id);

        // Delete image
        if ($usp->image) {
            Storage::delete('public/usps/' . $usp->image);
        }

        $usp->delete();

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

        $usps = Usp::whereIn('id', $ids)->get();

        foreach ($usps as $usp) {
            // Delete image
            if ($usp->image) {
                Storage::delete('public/usps/' . $usp->image);
            }
            $usp->delete();
        }

        return response()->json(['status' => 'success']);
    }
}
