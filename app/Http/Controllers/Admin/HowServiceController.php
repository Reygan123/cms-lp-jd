<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\HowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HowServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = HowService::query()->with('service');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('service_id') && !empty($request->service_id)) {
            $query->where('service_id', $request->service_id);
        }

        $howServices = $query->latest()->paginate(10);
        $services = Service::all();

        return view('admin.howservice.index', compact('howServices', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::all();
        return view('admin.howservice.create', compact('services'));
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
            $path = $image->storeAs('public/how-services', $filename);
            $validated['image'] = $filename;
        }

        HowService::create($validated);

        return redirect()->route('admin.how-service.index')->with('success', 'How Service created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(HowService $howService)
    {
        return view('admin.howservice.show', compact('howService'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HowService $howService)
    {
        $services = Service::all();
        return view('admin.howservice.edit', compact('howService', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HowService $howService)
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
            if ($howService->image) {
                Storage::delete('public/how-services/' . $howService->image);
            }

            // Upload new image
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/how-services', $filename);
            $validated['image'] = $filename;
        } else {
            $validated['image'] = $howService->image;
        }

        $howService->update($validated);

        return redirect()->route('admin.how-service.index')->with('success', 'How Service updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $howService = HowService::findOrFail($id);

        // Delete image
        if ($howService->image) {
            Storage::delete('public/how-services/' . $howService->image);
        }

        $howService->delete();

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

        $howServices = HowService::whereIn('id', $ids)->get();

        foreach ($howServices as $howService) {
            // Delete image
            if ($howService->image) {
                Storage::delete('public/how-services/' . $howService->image);
            }
            $howService->delete();
        }

        return response()->json(['status' => 'success']);
    }
}
