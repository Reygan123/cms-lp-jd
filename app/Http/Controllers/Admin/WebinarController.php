<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Webinar;
use App\Models\WebinarEpisode;
use App\Models\WebinarRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class WebinarController extends Controller
{
    public function index()
    {
        $webinars = Webinar::withCount(['episodes', 'registrations'])->latest()->paginate(10);
        return view('admin.webinar.index', compact('webinars'));
    }

    public function create()
    {
        return view('admin.webinar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'speaker_name' => 'required|string|max:255',
            'chapter_number' => 'required|integer|min:1',
            'all_access_price' => 'required|numeric|min:0',
            'status' => 'required|in:active,draft,closed',
            'speaker_photo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:3000',
        ]);

        $photoPath = null;
        if ($request->hasFile('speaker_photo')) {
            $photo = $request->file('speaker_photo');
            $filename = 'speaker_' . time() . '_' . Str::random(6) . '.' . $photo->getClientOriginalExtension();
            $photoPath = $photo->storeAs('public/speakers', $filename);
            $photoPath = str_replace('public/', '', $photoPath);
        }

        $code = 'chapter-' . $request->chapter_number;
        $slug = Str::slug($request->title, '-') . '-' . time();

        $webinar = Webinar::create([
            'code' => $code,
            'chapter_number' => $request->chapter_number,
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'speaker_name' => $request->speaker_name,
            'speaker_title' => $request->speaker_title,
            'speaker_photo' => $photoPath,
            'wa_group_url' => $request->wa_group_url,
            'all_access_price' => $request->all_access_price,
            'all_access_original_price' => $request->all_access_original_price ?: null,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.webinar.edit', $webinar->id)->with('success', 'Webinar Chapter berhasil dibuat. Silakan kelola episode di bawah.');
    }

    public function edit($id)
    {
        $webinar = Webinar::with('episodes')->findOrFail($id);
        return view('admin.webinar.edit', compact('webinar'));
    }

    public function update(Request $request, $id)
    {
        $webinar = Webinar::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'speaker_name' => 'required|string|max:255',
            'chapter_number' => 'required|integer|min:1',
            'all_access_price' => 'required|numeric|min:0',
            'status' => 'required|in:active,draft,closed',
            'speaker_photo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:3000',
        ]);

        $data = [
            'chapter_number' => $request->chapter_number,
            'title' => $request->title,
            'description' => $request->description,
            'speaker_name' => $request->speaker_name,
            'speaker_title' => $request->speaker_title,
            'wa_group_url' => $request->wa_group_url,
            'all_access_price' => $request->all_access_price,
            'all_access_original_price' => $request->all_access_original_price ?: null,
            'status' => $request->status,
        ];

        if ($request->hasFile('speaker_photo')) {
            if ($webinar->speaker_photo) {
                Storage::delete('public/' . $webinar->speaker_photo);
            }
            $photo = $request->file('speaker_photo');
            $filename = 'speaker_' . time() . '_' . Str::random(6) . '.' . $photo->getClientOriginalExtension();
            $path = $photo->storeAs('public/speakers', $filename);
            $data['speaker_photo'] = str_replace('public/', '', $path);
        }

        $webinar->update($data);

        return redirect()->route('admin.webinar.edit', $webinar->id)->with('success', 'Data Webinar berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $webinar = Webinar::findOrFail($id);
        if ($webinar->speaker_photo) {
            Storage::delete('public/' . $webinar->speaker_photo);
        }
        $webinar->delete();

        return redirect()->route('admin.webinar.index')->with('success', 'Webinar berhasil dihapus.');
    }

    public function storeEpisode(Request $request, $webinarId)
    {
        $webinar = Webinar::findOrFail($webinarId);

        $request->validate([
            'title' => 'required|string|max:255',
            'episode_number' => 'required|integer|min:1',
            'pricing_type' => 'required|in:free_donation,paid',
            'price' => 'required|numeric|min:0',
        ]);

        $features = array_filter(array_map('trim', explode("\n", $request->features ?: '')));

        WebinarEpisode::create([
            'webinar_id' => $webinar->id,
            'code' => 'ep-' . $request->episode_number,
            'episode_number' => $request->episode_number,
            'title' => $request->title,
            'description' => $request->description,
            'date_label' => $request->date_label,
            'time_label' => $request->time_label,
            'pricing_type' => $request->pricing_type,
            'price' => $request->price,
            'original_price' => $request->original_price ?: null,
            'requires_ig_proof' => $request->has('requires_ig_proof'),
            'assessment_voucher_included' => $request->has('assessment_voucher_included'),
            'features' => array_values($features),
            'sort_order' => $request->sort_order ?: $request->episode_number,
            'status' => $request->status ?: 'active',
        ]);

        return redirect()->route('admin.webinar.edit', $webinar->id)->with('success', 'Episode baru berhasil ditambahkan.');
    }

    public function updateEpisode(Request $request, $webinarId, $episodeId)
    {
        $webinar = Webinar::findOrFail($webinarId);
        $episode = WebinarEpisode::where('webinar_id', $webinar->id)->findOrFail($episodeId);

        $request->validate([
            'title' => 'required|string|max:255',
            'episode_number' => 'required|integer|min:1',
            'pricing_type' => 'required|in:free_donation,paid',
            'price' => 'required|numeric|min:0',
        ]);

        $features = array_filter(array_map('trim', explode("\n", $request->features ?: '')));

        $episode->update([
            'episode_number' => $request->episode_number,
            'code' => 'ep-' . $request->episode_number,
            'title' => $request->title,
            'description' => $request->description,
            'date_label' => $request->date_label,
            'time_label' => $request->time_label,
            'pricing_type' => $request->pricing_type,
            'price' => $request->price,
            'original_price' => $request->original_price ?: null,
            'requires_ig_proof' => $request->has('requires_ig_proof'),
            'assessment_voucher_included' => $request->has('assessment_voucher_included'),
            'features' => array_values($features),
            'sort_order' => $request->sort_order ?: $request->episode_number,
            'status' => $request->status ?: 'active',
        ]);

        return redirect()->route('admin.webinar.edit', $webinar->id)->with('success', 'Episode berhasil diperbarui.');
    }

    public function destroyEpisode($webinarId, $episodeId)
    {
        $episode = WebinarEpisode::where('webinar_id', $webinarId)->findOrFail($episodeId);
        $episode->delete();

        return redirect()->route('admin.webinar.edit', $webinarId)->with('success', 'Episode berhasil dihapus.');
    }

    public function registrations(Request $request)
    {
        $query = WebinarRegistration::latest();

        if ($request->filled('status') && $request->status !== 'ALL') {
            $query->where('payment_status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('full_name', 'like', "%{$s}%")
                  ->orWhere('whatsapp', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('order_id', 'like', "%{$s}%");
            });
        }

        if ($request->filled('episode')) {
            $query->where('episode_id', $request->episode);
        }

        $registrations = $query->paginate(20)->withQueryString();
        $episodes = WebinarEpisode::select('code', 'title')->distinct()->get();

        $stats = [
            'total' => WebinarRegistration::count(),
            'paid' => WebinarRegistration::where('payment_status', 'PAID')->count(),
            'pending' => WebinarRegistration::where('payment_status', 'PENDING')->count(),
            'revenue' => WebinarRegistration::where('payment_status', 'PAID')->sum('total_amount'),
        ];

        return view('admin.webinar.registrations', compact('registrations', 'episodes', 'stats'));
    }

    public function markRegistrationPaid($id)
    {
        $reg = WebinarRegistration::findOrFail($id);
        $reg->update([
            'payment_status' => 'PAID',
            'paid_at' => now(),
        ]);

        return back()->with('success', 'Status pendaftaran Order ' . $reg->order_id . ' berhasil diubah menjadi PAID.');
    }
}

