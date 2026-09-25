@extends('layouts.app', ['title' => 'Edit Paket Bundling - ' . $pelatihan->title])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="card-title mb-0">Edit Paket Bundling</h5>
                            <small class="text-muted">{{ $pelatihan->title }}</small>
                        </div>
                        <a href="{{ route('admin.pelatihan.bundle.index', $pelatihan->id) }}" class="btn btn-secondary btn-rounded btn-sm">
                            <i class="fa-solid fa-arrow-left mr-1"></i>Kembali
                        </a>
                    </div>

                    @include('layouts.alert')

                    <form action="{{ route('admin.pelatihan.bundle.update', [$pelatihan->id, $bundle->id]) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="form-group">
                            <label>Nama Paket <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $bundle->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Jumlah Orang dalam Paket <span class="text-danger">*</span></label>
                            <input type="number" name="person_count" class="form-control" min="1" value="{{ old('person_count', $bundle->person_count) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Harga Total Paket (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="bundle_price" class="form-control" min="0" value="{{ old('bundle_price', $bundle->bundle_price) }}" required>
                            <small class="text-muted">Harga satuan reguler: Rp{{ number_format($pelatihan->price, 0, ',', '.') }}</small>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Paket</label>
                            <input type="text" name="description" class="form-control" value="{{ old('description', $bundle->description) }}">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $bundle->is_active ? '1' : '0') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Paket Aktif</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-rounded">
                            <i class="fa-solid fa-save mr-1"></i>Perbarui Paket
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
