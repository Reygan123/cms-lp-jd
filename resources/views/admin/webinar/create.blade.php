@extends('layouts.app', ['title' => 'Buat Webinar Baru'])

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-0">Buat Webinar Chapter Baru</h4>
                        <p class="text-muted small mb-0">Isi data tema chapter utama dan profil pembicara</p>
                    </div>
                    <a href="{{ route('admin.webinar.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fa fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.webinar.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label class="font-weight-bold">Nomor Chapter <span class="text-danger">*</span></label>
                                <input type="number" name="chapter_number" class="form-control" value="{{ old('chapter_number', 1) }}" required min="1">
                            </div>
                            <div class="col-md-9 form-group">
                                <label class="font-weight-bold">Judul Grand Theme Webinar <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="Contoh: Sering Overthinking Soal Masa Depan? Temukan Jatidiri Aslimu">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Deskripsi Ringkas</label>
                            <textarea name="description" rows="3" class="form-control" placeholder="Jelaskan tujuan umum dan sasaran dari seri webinar ini...">{{ old('description') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Nama Pembicara Utama <span class="text-danger">*</span></label>
                                <input type="text" name="speaker_name" class="form-control" value="{{ old('speaker_name', 'Ibu Miryam Ariadne Sigarlaki, M.Psi., Psikolog') }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Gelar / Jabatan Pembicara</label>
                                <input type="text" name="speaker_title" class="form-control" value="{{ old('speaker_title', 'Senior Psychologist Jatidiri.app & Pakar Psikologi Klinis') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Foto Pembicara</label>
                                <input type="file" name="speaker_photo" class="form-control-file" accept="image/*">
                                <small class="text-muted">Format: JPG, PNG, WebP. Maks 3MB.</small>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Link WhatsApp Group Peserta</label>
                                <input type="url" name="wa_group_url" class="form-control" value="{{ old('wa_group_url', 'https://chat.whatsapp.com/') }}" placeholder="https://chat.whatsapp.com/...">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Harga All-Access Pass (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="all_access_price" class="form-control" value="{{ old('all_access_price', 79000) }}" required min="0">
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Harga Coret All-Access (Rp)</label>
                                <input type="number" name="all_access_original_price" class="form-control" value="{{ old('all_access_original_price', 198000) }}" min="0">
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Status Webinar <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Aktif (Tampil di Landing Page)</option>
                                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft (Sembunyikan)</option>
                                    <option value="closed" {{ old('status') === 'closed' ? 'selected' : '' }}>Tutup Pendaftaran</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fa fa-save mr-1"></i> Simpan & Lanjutkan Kelola Episode
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

