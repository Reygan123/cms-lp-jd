@extends('layouts.app', ['title' => 'Tambah Paket Bundling - ' . $pelatihan->title])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="card-title mb-0">Tambah Paket Bundling</h5>
                            <small class="text-muted">{{ $pelatihan->title }}</small>
                        </div>
                        <a href="{{ route('admin.pelatihan.bundle.index', $pelatihan->id) }}" class="btn btn-secondary btn-rounded btn-sm">
                            <i class="fa-solid fa-arrow-left mr-1"></i>Kembali
                        </a>
                    </div>

                    @include('layouts.alert')

                    <form action="{{ route('admin.pelatihan.bundle.store', $pelatihan->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Nama Paket <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Paket 3 Orang" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Jumlah Orang dalam Paket <span class="text-danger">*</span></label>
                            <input type="number" name="person_count" class="form-control" min="1" placeholder="Contoh: 3" value="{{ old('person_count') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Harga Total Paket (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="bundle_price" class="form-control" min="0" placeholder="Contoh: 2100000" value="{{ old('bundle_price') }}" required>
                            <small class="text-muted">Harga satuan reguler: Rp{{ number_format($pelatihan->price, 0, ',', '.') }} × jumlah orang</small>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Paket</label>
                            <input type="text" name="description" class="form-control" placeholder="Opsional, misal: Hemat Rp150.000" value="{{ old('description') }}">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Paket Aktif (tampil di form pendaftaran)</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-rounded">
                            <i class="fa-solid fa-save mr-1"></i>Simpan Paket
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
