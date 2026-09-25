<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use App\Models\PelatihanReferral;
use Illuminate\Http\Request;

class PelatihanReferralController extends Controller
{
    public function index($pelatihanId)
    {
        $pelatihan = Pelatihan::findOrFail($pelatihanId);
        $referrals = PelatihanReferral::where('pelatihan_id', $pelatihanId)->withCount('participants')->latest()->get();
        return view('admin.pelatihan.referral.index', compact('pelatihan', 'referrals'));
    }

    public function create($pelatihanId)
    {
        $pelatihan = Pelatihan::findOrFail($pelatihanId);
        return view('admin.pelatihan.referral.create', compact('pelatihan'));
    }

    public function store(Request $request, $pelatihanId)
    {
        $this->validate($request, [
            'code'           => 'required|unique:pelatihan_referrals,code',
            'discount_type'  => 'required|in:nominal,percent',
            'discount_value' => 'required|numeric|min:0',
            'max_usage'      => 'nullable|integer|min:1',
        ]);

        $pelatihan = Pelatihan::findOrFail($pelatihanId);

        PelatihanReferral::create([
            'pelatihan_id'   => $pelatihan->id,
            'code'           => strtoupper(trim($request->code)),
            'partner_name'   => $request->partner_name,
            'discount_type'  => $request->discount_type,
            'discount_value' => $request->discount_value,
            'max_usage'      => $request->max_usage,
            'is_active'      => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.pelatihan.referral.index', $pelatihanId)
            ->with(['success' => 'Kode Referral Berhasil Disimpan!']);
    }

    public function edit($pelatihanId, $referralId)
    {
        $pelatihan = Pelatihan::findOrFail($pelatihanId);
        $referral = PelatihanReferral::where('pelatihan_id', $pelatihanId)->findOrFail($referralId);
        return view('admin.pelatihan.referral.edit', compact('pelatihan', 'referral'));
    }

    public function update(Request $request, $pelatihanId, $referralId)
    {
        $this->validate($request, [
            'code'           => 'required|unique:pelatihan_referrals,code,' . $referralId,
            'discount_type'  => 'required|in:nominal,percent',
            'discount_value' => 'required|numeric|min:0',
            'max_usage'      => 'nullable|integer|min:1',
        ]);

        $referral = PelatihanReferral::where('pelatihan_id', $pelatihanId)->findOrFail($referralId);
        $referral->update([
            'code'           => strtoupper(trim($request->code)),
            'partner_name'   => $request->partner_name,
            'discount_type'  => $request->discount_type,
            'discount_value' => $request->discount_value,
            'max_usage'      => $request->max_usage,
            'is_active'      => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.pelatihan.referral.index', $pelatihanId)
            ->with(['success' => 'Kode Referral Berhasil Diupdate!']);
    }

    public function destroy($pelatihanId, $referralId)
    {
        $referral = PelatihanReferral::where('pelatihan_id', $pelatihanId)->findOrFail($referralId);
        $referral->delete();
        return response()->json(['status' => 'success']);
    }
}
