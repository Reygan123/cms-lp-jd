<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use App\Models\PelatihanQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PelatihanController extends Controller
{
    public function index()
    {
        $pelatihans = Pelatihan::withCount('participants')->latest()->paginate(10);
        return view('admin.pelatihan.index', compact('pelatihans'));
    }

    public function create()
    {
        return view('admin.pelatihan.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title'    => 'required',
            'price'    => 'required|numeric|min:0',
            'status'   => 'required|in:draft,active,closed',
            'image'    => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2000',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/pelatihans', $image->hashName());
            $imageName = $image->hashName();
        }

        $pelatihan = Pelatihan::create([
            'title'             => $request->title,
            'slug'              => Str::slug($request->title, '-') . '-' . time(),
            'batch'             => $request->batch,
            'description'       => $request->description,
            'start_date'        => $request->start_date,
            'end_date'          => $request->end_date,
            'start_time'        => $request->start_time,
            'end_time'          => $request->end_time,
            'location'          => $request->location,
            'price'             => $request->price,
            'bank_name'         => $request->bank_name,
            'bank_account'      => $request->bank_account,
            'bank_holder'       => $request->bank_holder,
            'quota'             => $request->quota,
            'whatsapp_contact'  => $request->whatsapp_contact,
            'email_contact'     => $request->email_contact,
            'image'             => $imageName,
            'status'            => $request->status,
        ]);

        if ($request->has('questions')) {
            foreach ($request->questions as $index => $q) {
                if (empty($q['question'])) continue;
                $options = null;
                if (!empty($q['options'])) {
                    $optionLines = array_filter(array_map('trim', explode("\n", $q['options'])));
                    $options = array_values($optionLines);
                }
                PelatihanQuestion::create([
                    'pelatihan_id'          => $pelatihan->id,
                    'question'              => $q['question'],
                    'type'                  => $q['type'] ?? 'text',
                    'options'               => $options,
                    'is_required'           => isset($q['is_required']) ? 1 : 0,
                    'sort_order'            => $index,
                    'conditional_on_question' => $q['conditional_on_question'] ?? null,
                    'conditional_on_value'  => $q['conditional_on_value'] ?? null,
                ]);
            }
        }

        if ($pelatihan) {
            return redirect()->route('admin.pelatihan.index')->with(['success' => 'Data Pelatihan Berhasil Disimpan!']);
        }
        return redirect()->route('admin.pelatihan.index')->with(['error' => 'Data Gagal Disimpan!']);
    }

    public function show($id)
    {
        $pelatihan = Pelatihan::with(['questions', 'referrals'])->findOrFail($id);
        return view('admin.pelatihan.show', compact('pelatihan'));
    }

    public function edit($id)
    {
        $pelatihan = Pelatihan::with('questions')->findOrFail($id);
        return view('admin.pelatihan.edit', compact('pelatihan'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'    => 'required',
            'price'    => 'required|numeric|min:0',
            'status'   => 'required|in:draft,active,closed',
            'image'    => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2000',
        ]);

        $pelatihan = Pelatihan::findOrFail($id);

        $imageName = $pelatihan->image;
        if ($request->hasFile('image')) {
            if ($pelatihan->image) {
                Storage::disk('local')->delete('public/pelatihans/' . $pelatihan->image);
            }
            $image = $request->file('image');
            $image->storeAs('public/pelatihans', $image->hashName());
            $imageName = $image->hashName();
        }

        $pelatihan->update([
            'title'             => $request->title,
            'slug'              => $pelatihan->slug ?: (Str::slug($request->title, '-') . '-' . $pelatihan->id),
            'batch'             => $request->batch,
            'description'       => $request->description,
            'start_date'        => $request->start_date,
            'end_date'          => $request->end_date,
            'start_time'        => $request->start_time,
            'end_time'          => $request->end_time,
            'location'          => $request->location,
            'price'             => $request->price,
            'bank_name'         => $request->bank_name,
            'bank_account'      => $request->bank_account,
            'bank_holder'       => $request->bank_holder,
            'quota'             => $request->quota,
            'whatsapp_contact'  => $request->whatsapp_contact,
            'email_contact'     => $request->email_contact,
            'image'             => $imageName,
            'status'            => $request->status,
        ]);

        $pelatihan->questions()->delete();
        if ($request->has('questions')) {
            foreach ($request->questions as $index => $q) {
                if (empty($q['question'])) continue;
                $options = null;
                if (!empty($q['options'])) {
                    $optionLines = array_filter(array_map('trim', explode("\n", $q['options'])));
                    $options = array_values($optionLines);
                }
                PelatihanQuestion::create([
                    'pelatihan_id'          => $pelatihan->id,
                    'question'              => $q['question'],
                    'type'                  => $q['type'] ?? 'text',
                    'options'               => $options,
                    'is_required'           => isset($q['is_required']) ? 1 : 0,
                    'sort_order'            => $index,
                    'conditional_on_question' => $q['conditional_on_question'] ?? null,
                    'conditional_on_value'  => $q['conditional_on_value'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.pelatihan.index')->with(['success' => 'Data Pelatihan Berhasil Diupdate!']);
    }

    public function destroy($id)
    {
        $pelatihan = Pelatihan::findOrFail($id);
        if ($pelatihan->image) {
            Storage::disk('local')->delete('public/pelatihans/' . $pelatihan->image);
        }
        $pelatihan->delete();
        return response()->json(['status' => 'success']);
    }
}
