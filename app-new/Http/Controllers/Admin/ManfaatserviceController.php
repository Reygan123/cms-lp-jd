<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ManfaatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ManfaatServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ManfaatService::query()->with('service');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('service_id') && !empty($request->service_id)) {
            $query->where('service_id', $request->service_id);
        }

        $manfaatServices = $query->latest()->paginate(10);
        $services = Service::all();

        return view('admin.manfaatService.index', compact('manfaatServices', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::all();
        return view('admin.manfaatservice.create', compact('services'));
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
            $path = $image->storeAs('public/manfaat-services', $filename);
            $validated['image'] = $filename;
        }

        ManfaatService::create($validated);

        return redirect()->route('admin.manfaat-service.index')->with('success', 'Manfaat Service created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ManfaatService $manfaatService)
    {
        return view('admin.manfaatservice.show', compact('manfaatService'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ManfaatService $manfaatService)
    {
        $services = Service::all();
        return view('admin.manfaatservice.edit', compact('manfaatService', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ManfaatService $manfaatService)
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
            if ($manfaatService->image) {
                Storage::delete('public/manfaat-services/' . $manfaatService->image);
            }

            // Upload new image
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/manfaat-services', $filename);
            $validated['image'] = $filename;
        } else {
            $validated['image'] = $manfaatService->image;
        }

        $manfaatService->update($validated);

        return redirect()->route('admin.manfaat-service.index')->with('success', 'Manfaat Service updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $manfaatService = ManfaatService::findOrFail($id);

        // Delete image
        if ($manfaatService->image) {
            Storage::delete('public/manfaat-services/' . $manfaatService->image);
        }

        $manfaatService->delete();

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

        $manfaatServices = ManfaatService::whereIn('id', $ids)->get();

        foreach ($manfaatServices as $manfaatService) {
            // Delete image
            if ($manfaatService->image) {
                Storage::delete('public/manfaat-services/' . $manfaatService->image);
            }
            $manfaatService->delete();
        }

        return response()->json(['status' => 'success']);
    }
}
