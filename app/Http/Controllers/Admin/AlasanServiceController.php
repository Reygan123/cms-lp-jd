<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\AlasanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AlasanServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AlasanService::query()->with('service');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('service_id') && !empty($request->service_id)) {
            $query->where('service_id', $request->service_id);
        }

        $alasanServices = $query->latest()->paginate(10);
        $services = Service::all();

        return view('admin.alasanService.index', compact('alasanServices', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::all();
        return view('admin.alasanService.create', compact('services'));
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
            $path = $image->storeAs('public/alasan-services', $filename);
            $validated['image'] = $filename;
        }

        AlasanService::create($validated);

        return redirect()->route('admin.alasan-service.index')->with('success', 'Alasan Service created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(AlasanService $alasanService)
    {
        return view('admin.alasanService.show', compact('alasanService'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AlasanService $alasanService)
    {
        $services = Service::all();
        return view('admin.alasanService.edit', compact('alasanService', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AlasanService $alasanService)
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
            if ($alasanService->image) {
                Storage::delete('public/alasan-services/' . $alasanService->image);
            }

            // Upload new image
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/alasan-services', $filename);
            $validated['image'] = $filename;
        } else {
            $validated['image'] = $alasanService->image;
        }

        $alasanService->update($validated);

        return redirect()->route('admin.alasan-service.index')->with('success', 'Alasan Service updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $alasanService = AlasanService::findOrFail($id);

        // Delete image
        if ($alasanService->image) {
            Storage::delete('public/alasan-services/' . $alasanService->image);
        }

        $alasanService->delete();

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

        $alasanServices = AlasanService::whereIn('id', $ids)->get();

        foreach ($alasanServices as $alasanService) {
            // Delete image
            if ($alasanService->image) {
                Storage::delete('public/alasan-services/' . $alasanService->image);
            }
            $alasanService->delete();
        }

        return response()->json(['status' => 'success']);
    }
}
