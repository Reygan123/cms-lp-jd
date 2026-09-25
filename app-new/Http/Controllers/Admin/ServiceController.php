<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $services = Service::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%$search%")
                        ->orWhere('title1', 'like', "%$search%")
                        ->orWhere('title2', 'like', "%$search%");
        })->paginate(10);

        return view('admin.service.index', compact('services', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.service.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title1' => 'nullable|string|max:255',
            'description1' => 'nullable|string',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'title2' => 'nullable|string|max:255',
            'description2' => 'nullable|string',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'title3' => 'nullable|string|max:255',
            'description3' => 'nullable|string',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'title4' => 'nullable|string|max:255',
            'description4' => 'nullable|string',
            'image4' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $service = new Service();
        $service->name = $validated['name'];
        $service->slug = Str::slug($validated['name']);
        $service->title1 = $validated['title1'] ?? null;
        $service->description1 = $validated['description1'] ?? null;
        $service->title2 = $validated['title2'] ?? null;
        $service->description2 = $validated['description2'] ?? null;
        $service->title3 = $validated['title3'] ?? null;
        $service->description3 = $validated['description3'] ?? null;
        $service->title4 = $validated['title4'] ?? null;
        $service->description4 = $validated['description4'] ?? null;

        // Upload images if provided
        for ($i = 1; $i <= 4; $i++) {
            $imageField = 'image'.$i;
            if ($request->hasFile($imageField)) {
                $image = $request->file($imageField);
                $filename = time().'_'.$image->getClientOriginalName();
                $path = $image->storeAs('public/services', $filename);
                $service->$imageField = $filename;
            }
        }

        $service->save();

        return redirect()->route('admin.service.index')->with('success', 'Service created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return view('admin.service.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        return view('admin.service.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title1' => 'nullable|string|max:255',
            'description1' => 'nullable|string',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'title2' => 'nullable|string|max:255',
            'description2' => 'nullable|string',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'title3' => 'nullable|string|max:255',
            'description3' => 'nullable|string',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'title4' => 'nullable|string|max:255',
            'description4' => 'nullable|string',
            'image4' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $service->name = $validated['name'];
        $service->slug = Str::slug($validated['name']);
        $service->title1 = $validated['title1'] ?? null;
        $service->description1 = $validated['description1'] ?? null;
        $service->title2 = $validated['title2'] ?? null;
        $service->description2 = $validated['description2'] ?? null;
        $service->title3 = $validated['title3'] ?? null;
        $service->description3 = $validated['description3'] ?? null;
        $service->title4 = $validated['title4'] ?? null;
        $service->description4 = $validated['description4'] ?? null;

        // Handle image updates
        for ($i = 1; $i <= 4; $i++) {
            $imageField = 'image'.$i;
            if ($request->hasFile($imageField)) {
                // Delete old image if exists
                if ($service->$imageField) {
                    Storage::delete('public/services/'.$service->$imageField);
                }

                // Upload new image
                $image = $request->file($imageField);
                $filename = time().'_'.$image->getClientOriginalName();
                $path = $image->storeAs('public/services', $filename);
                $service->$imageField = $filename;
            }
        }

        $service->save();

        return redirect()->route('admin.service.index')->with('success', 'Service updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        try {
            // Delete associated images
            for ($i = 1; $i <= 4; $i++) {
                $imageField = 'image'.$i;
                if ($service->$imageField) {
                    Storage::delete('public/services/'.$service->$imageField);
                }
            }

            $service->delete();

            // Return JSON response for AJAX
            if (request()->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Service deleted successfully!'
                ]);
            }

            return redirect()->route('admin.service.index')->with('success', 'Service deleted successfully!');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to delete service!'
                ]);
            }

            return redirect()->route('admin.service.index')->with('error', 'Failed to delete service!');
        }
    }

    /**
     * Delete specific image from service
     */
    public function deleteImage(Request $request, $id, $field)
    {
        try {
            $service = Service::findOrFail($id);

            // Validate field
            if (!in_array($field, ['image1', 'image2', 'image3', 'image4'])) {
                return redirect()->back()->with('error', 'Invalid image field.');
            }

            // Delete image file if exists
            if ($service->$field) {
                Storage::delete('public/services/'.$service->$field);
                $service->$field = null;
                $service->save();
            }

            return redirect()->back()->with('success', 'Image deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete image!');
        }
    }

    /**
     * Mass destroy services
     */
    public function massDestroy(Request $request)
    {
        $ids = $request->input('ids');

        if (empty($ids)) {
            return redirect()->route('admin.service.index')->with('error', 'Please select services to delete.');
        }

        $services = Service::whereIn('id', $ids)->get();

        foreach ($services as $service) {
            // Delete associated images
            for ($i = 1; $i <= 4; $i++) {
                $imageField = 'image'.$i;
                if ($service->$imageField) {
                    Storage::delete('public/services/'.$service->$imageField);
                }
            }
            $service->delete();
        }

        return redirect()->route('admin.service.index')->with('success', 'Selected services deleted successfully!');
    }
}
