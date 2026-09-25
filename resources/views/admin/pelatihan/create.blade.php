@extends('layouts.app', ['title' => 'Tambah Pelatihan'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Tambah Pelatihan Baru</h5>
                    <form action="{{ route('admin.pelatihan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <h6 class="text-primary mb-3 border-bottom pb-2">Informasi Event</h6>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group mb-4">
                                    <label class="text-label">Judul Pelatihan <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Pelatihan Peer Counselor: Active Listening">
                                    @error('title')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <label class="text-label">Batch</label>
                                    <input class="form-control" type="text" name="batch" value="{{ old('batch') }}" placeholder="Contoh: Batch 3">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-4">
                                    <label class="text-label">Tanggal Mulai</label>
                                    <input class="form-control" type="date" name="start_date" value="{{ old('start_date') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-4">
                                    <label class="text-label">Tanggal Selesai</label>
                                    <input class="form-control" type="date" name="end_date" value="{{ old('end_date') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-4">
                                    <label class="text-label">Jam Mulai</label>
                                    <input class="form-control" type="time" name="start_time" value="{{ old('start_time') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-4">
                                    <label class="text-label">Jam Selesai</label>
                                    <input class="form-control" type="time" name="end_time" value="{{ old('end_time') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="text-label">Lokasi</label>
                                    <input class="form-control" type="text" name="location" value="{{ old('location') }}" placeholder="Alamat lengkap lokasi pelatihan">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-4">
                                    <label class="text-label">Harga (Rp) <span class="text-danger">*</span></label>
                                    <input class="form-control" type="number" name="price" value="{{ old('price', 0) }}" min="0">
                                    @error('price')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-4">
                                    <label class="text-label">Kuota Peserta</label>
                                    <input class="form-control" type="number" name="quota" value="{{ old('quota') }}" min="1" placeholder="Kosongkan = tidak terbatas">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="text-label">Deskripsi / Keterangan Event</label>
                            <textarea id="editor-desc" name="description">{{ old('description') }}</textarea>
                        </div>

                        <h6 class="text-primary mb-3 border-bottom pb-2">Informasi Pembayaran & Kontak</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <label class="text-label">Nama Bank</label>
                                    <input class="form-control" type="text" name="bank_name" value="{{ old('bank_name') }}" placeholder="Contoh: Bank Mandiri">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <label class="text-label">Nomor Rekening</label>
                                    <input class="form-control" type="text" name="bank_account" value="{{ old('bank_account') }}" placeholder="Contoh: 1320529111818">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <label class="text-label">Atas Nama</label>
                                    <input class="form-control" type="text" name="bank_holder" value="{{ old('bank_holder') }}" placeholder="Nama pemilik rekening">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <label class="text-label">WhatsApp Admin</label>
                                    <input class="form-control" type="text" name="whatsapp_contact" value="{{ old('whatsapp_contact') }}" placeholder="08xxx">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <label class="text-label">Email Admin</label>
                                    <input class="form-control" type="email" name="email_contact" value="{{ old('email_contact') }}" placeholder="admin@example.com">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <label class="text-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-control" name="status">
                                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                                        <option value="closed" {{ old('status') === 'closed' ? 'selected' : '' }}>Ditutup</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="text-label">Gambar / Banner Pelatihan</label>
                            <input type="file" class="dropify" name="image" data-default-file="">
                            @error('image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <h6 class="text-primary mb-3 border-bottom pb-2 mt-4">Pertanyaan Form Pendaftaran</h6>
                        <p class="text-muted small mb-3">Tambahkan pertanyaan yang akan diisi oleh calon peserta saat mendaftar.</p>
                        <div id="questions-container">
                        </div>

                        <button type="button" id="btn-add-question" class="btn btn-outline-primary btn-rounded btn-sm mb-4">
                            <i class="fa-solid fa-plus mr-1"></i> Tambah Pertanyaan
                        </button>

                        <div class="flex justify-start mt-2">
                            <a href="{{ route('admin.pelatihan.index') }}" class="btn btn-secondary mr-2">Batal</a>
                            <button type="submit" class="btn btn-primary">SIMPAN PELATIHAN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<template id="question-template">
    <div class="question-item card mb-3 border">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <strong class="text-muted small">Pertanyaan <span class="q-num"></span></strong>
                <button type="button" class="btn btn-danger btn-xs btn-remove-question">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="form-group mb-3">
                        <label class="text-label small">Teks Pertanyaan</label>
                        <input type="text" class="form-control" name="questions[IDX][question]" placeholder="Tulis pertanyaan di sini...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="text-label small">Tipe Jawaban</label>
                        <select class="form-control q-type-select" name="questions[IDX][type]">
                            <option value="text">Teks Singkat</option>
                            <option value="textarea">Teks Panjang</option>
                            <option value="email">Email</option>
                            <option value="number">Angka</option>
                            <option value="date">Tanggal</option>
                            <option value="radio">Pilihan Tunggal (Radio)</option>
                            <option value="checkbox">Pilihan Ganda (Checkbox)</option>
                            <option value="select">Dropdown</option>
                            <option value="file">Upload File</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-3">
                        <label class="text-label small">Wajib?</label>
                        <div class="pt-2">
                            <input type="checkbox" name="questions[IDX][is_required]" value="1" checked> Wajib
                        </div>
                    </div>
                </div>
            </div>
            <div class="q-options-wrapper" style="display:none;">
                <div class="form-group mb-3">
                    <label class="text-label small">Pilihan Jawaban <span class="text-muted">(satu pilihan per baris)</span></label>
                    <textarea class="form-control" name="questions[IDX][options]" rows="4" placeholder="Pilihan A&#10;Pilihan B&#10;Pilihan C"></textarea>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
var questionIndex = 0;

document.getElementById('btn-add-question').addEventListener('click', function() {
    var template = document.getElementById('question-template').innerHTML;
    template = template.replace(/IDX/g, questionIndex);
    var wrapper = document.createElement('div');
    wrapper.innerHTML = template;
    var item = wrapper.firstElementChild;
    item.querySelector('.q-num').textContent = questionIndex + 1;
    document.getElementById('questions-container').appendChild(item);

    item.querySelector('.q-type-select').addEventListener('change', function() {
        var needsOptions = ['radio', 'checkbox', 'select'].includes(this.value);
        item.querySelector('.q-options-wrapper').style.display = needsOptions ? 'block' : 'none';
    });

    item.querySelector('.btn-remove-question').addEventListener('click', function() {
        item.remove();
        renumberQuestions();
    });

    questionIndex++;
    renumberQuestions();
});

function renumberQuestions() {
    document.querySelectorAll('.question-item').forEach(function(item, idx) {
        item.querySelector('.q-num').textContent = idx + 1;
    });
}

ClassicEditor.create(document.querySelector('#editor-desc')).catch(function(error) { console.error(error); });
</script>
@endsection
