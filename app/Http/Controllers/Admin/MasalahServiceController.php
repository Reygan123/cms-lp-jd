<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\MasalahService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MasalahServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MasalahService::query()->with('service');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('service_id') && !empty($request->service_id)) {
            $query->where('service_id', $request->service_id);
        }

        $masalahServices = $query->latest()->paginate(10);
        $services = Service::all();

        return view('admin.masalahservice.index', compact('masalahServices', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::all();
        return view('admin.masalahservice.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/masalah-services', $filename);
            $validated['image'] = $filename;
        }

        MasalahService::create($validated);

        return redirect()->route('admin.masalah-service.index')->with('success', 'Masalah Service created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(MasalahService $masalahService)
    {
        return view('admin.masalahservice.show', compact('masalahService'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasalahService $masalahService)
    {
        $services = Service::all();
        return view('admin.masalahservice.edit', compact('masalahService', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasalahService $masalahService)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Update image if new one is uploaded
        if ($request->hasFile('image')) {
            // Delete old image
            if ($masalahService->image) {
                Storage::delete('public/masalah-services/' . $masalahService->image);
            }

            // Upload new image
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/masalah-services', $filename);
            $validated['image'] = $filename;
        } else {
            $validated['image'] = $masalahService->image;
        }

        $masalahService->update($validated);

        return redirect()->route('admin.masalah-service.index')->with('success', 'Masalah Service updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $masalahService = MasalahService::findOrFail($id);

        // Delete image
        if ($masalahService->image) {
            Storage::delete('public/masalah-services/' . $masalahService->image);
        }

        $masalahService->delete();

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

        $masalahServices = MasalahService::whereIn('id', $ids)->get();

        foreach ($masalahServices as $masalahService) {
            // Delete image
            if ($masalahService->image) {
                Storage::delete('public/masalah-services/' . $masalahService->image);
            }
            $masalahService->delete();
        }

        return response()->json(['status' => 'success']);
    }
}
