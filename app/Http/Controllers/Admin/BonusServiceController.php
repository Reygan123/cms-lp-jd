<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\BonusService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BonusServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BonusService::query()->with('service');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('service_id') && !empty($request->service_id)) {
            $query->where('service_id', $request->service_id);
        }

        $bonusServices = $query->latest()->paginate(10);
        $services = Service::all();

        return view('admin.bonusservice.index', compact('bonusServices', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::all();
        return view('admin.bonusservice.create', compact('services'));
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
            $path = $image->storeAs('public/bonus-services', $filename);
            $validated['image'] = $filename;
        }

        BonusService::create($validated);

        return redirect()->route('admin.bonus-service.index')->with('success', 'Bonus Service created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(BonusService $bonusService)
    {
        return view('admin.bonusservice.show', compact('bonusService'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BonusService $bonusService)
    {
        $services = Service::all();
        return view('admin.bonusservice.edit', compact('bonusService', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BonusService $bonusService)
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
            if ($bonusService->image) {
                Storage::delete('public/bonus-services/' . $bonusService->image);
            }

            // Upload new image
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/bonus-services', $filename);
            $validated['image'] = $filename;
        } else {
            $validated['image'] = $bonusService->image;
        }

        $bonusService->update($validated);

        return redirect()->route('admin.bonus-service.index')->with('success', 'Bonus Service updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $bonusService = BonusService::findOrFail($id);

        // Delete image
        if ($bonusService->image) {
            Storage::delete('public/bonus-services/' . $bonusService->image);
        }

        $bonusService->delete();

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

        $bonusServices = BonusService::whereIn('id', $ids)->get();

        foreach ($bonusServices as $bonusService) {
            // Delete image
            if ($bonusService->image) {
                Storage::delete('public/bonus-services/' . $bonusService->image);
            }
            $bonusService->delete();
        }

        return response()->json(['status' => 'success']);
    }
}
