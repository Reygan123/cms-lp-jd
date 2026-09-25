@extends('layouts.app', ['title' => 'Edit Kode Referral'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-1">Edit Kode Referral</h5>
                    <p class="text-muted small mb-4">{{ $pelatihan->title }}</p>

                    <form action="{{ route('admin.pelatihan.referral.update', [$pelatihan->id, $referral->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-4">
                            <label class="text-label">Kode Referral <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="code" value="{{ old('code', $referral->code) }}" style="text-transform:uppercase">
                            @error('code')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="text-label">Nama Mitra / PIC Marketing</label>
                            <input class="form-control" type="text" name="partner_name" value="{{ old('partner_name', $referral->partner_name) }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="text-label">Tipe Diskon <span class="text-danger">*</span></label>
                                    <select class="form-control" name="discount_type" id="discount_type">
                                        <option value="nominal" {{ old('discount_type', $referral->discount_type) === 'nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
                                        <option value="percent" {{ old('discount_type', $referral->discount_type) === 'percent' ? 'selected' : '' }}>Persentase (%)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="text-label" id="discount_label">
                                        Nilai Diskon ({{ old('discount_type', $referral->discount_type) === 'percent' ? '%' : 'Rp' }}) <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="number" name="discount_value" value="{{ old('discount_value', $referral->discount_value) }}" min="0" step="0.01">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="text-label">Batas Penggunaan</label>
                            <input class="form-control" type="number" name="max_usage" value="{{ old('max_usage', $referral->max_usage) }}" min="1" placeholder="Kosongkan = tidak terbatas">
                            <small class="text-muted">Sudah dipakai: {{ $referral->used_count }}x</small>
                        </div>

                        <div class="form-group mb-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $referral->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Kode Aktif</label>
                            </div>
                        </div>

                        <div class="d-flex">
                            <a href="{{ route('admin.pelatihan.referral.index', $pelatihan->id) }}" class="btn btn-secondary mr-2">Batal</a>
                            <button type="submit" class="btn btn-primary">SIMPAN PERUBAHAN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('discount_type').addEventListener('change', function() {
    var label = document.getElementById('discount_label');
    label.innerHTML = this.value === 'percent'
        ? 'Nilai Diskon (%) <span class="text-danger">*</span>'
        : 'Nilai Diskon (Rp) <span class="text-danger">*</span>';
});
</script>
@endsection
