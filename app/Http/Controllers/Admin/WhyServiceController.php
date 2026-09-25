<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\WhyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WhyServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = WhyService::query()->with('service');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('service_id') && !empty($request->service_id)) {
            $query->where('service_id', $request->service_id);
        }

        $whyServices = $query->latest()->paginate(10);
        $services = Service::all();

        return view('admin.whyservice.index', compact('whyServices', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::all();
        return view('admin.whyservice.create', compact('services'));
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
            $path = $image->storeAs('public/why-services', $filename);
            $validated['image'] = $filename;
        }

        WhyService::create($validated);

        return redirect()->route('admin.why-service.index')->with('success', 'Why Service created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(WhyService $whyService)
    {
        return view('admin.whyservice.show', compact('whyService'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WhyService $whyService)
    {
        $services = Service::all();
        return view('admin.whyservice.edit', compact('whyService', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WhyService $whyService)
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
            if ($whyService->image) {
                Storage::delete('public/why-services/' . $whyService->image);
            }

            // Upload new image
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/why-services', $filename);
            $validated['image'] = $filename;
        } else {
            $validated['image'] = $whyService->image;
        }

        $whyService->update($validated);

        return redirect()->route('admin.why-service.index')->with('success', 'Why Service updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $whyService = WhyService::findOrFail($id);

        // Delete image
        if ($whyService->image) {
            Storage::delete('public/why-services/' . $whyService->image);
        }

        $whyService->delete();

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

        $whyServices = WhyService::whereIn('id', $ids)->get();

        foreach ($whyServices as $whyService) {
            // Delete image
            if ($whyService->image) {
                Storage::delete('public/why-services/' . $whyService->image);
            }
            $whyService->delete();
        }

        return response()->json(['status' => 'success']);
    }
}
