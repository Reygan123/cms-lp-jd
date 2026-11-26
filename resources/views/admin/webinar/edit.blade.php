@extends('layouts.app', ['title' => 'Edit Webinar & Episode'])

@section('content')
<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-0">Edit Chapter {{ $webinar->chapter_number }}: {{ $webinar->title }}</h4>
                        <p class="text-muted small mb-0">Perbarui informasi grand theme, profil pembicara, dan harga all-access pass</p>
                    </div>
                    <a href="{{ route('admin.webinar.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fa fa-arrow-left mr-1"></i> Kembali ke Daftar
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.webinar.update', $webinar->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label class="font-weight-bold">Nomor Chapter <span class="text-danger">*</span></label>
                                <input type="number" name="chapter_number" class="form-control" value="{{ old('chapter_number', $webinar->chapter_number) }}" required min="1">
                            </div>
                            <div class="col-md-9 form-group">
                                <label class="font-weight-bold">Judul Grand Theme Webinar <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $webinar->title) }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Deskripsi Ringkas</label>
                            <textarea name="description" rows="3" class="form-control">{{ old('description', $webinar->description) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Nama Pembicara Utama <span class="text-danger">*</span></label>
                                <input type="text" name="speaker_name" class="form-control" value="{{ old('speaker_name', $webinar->speaker_name) }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Gelar / Jabatan Pembicara</label>
                                <input type="text" name="speaker_title" class="form-control" value="{{ old('speaker_title', $webinar->speaker_title) }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Foto Pembicara</label>
                                @if($webinar->speaker_photo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $webinar->speaker_photo) }}" alt="" class="rounded" width="80" height="80" style="object-fit: cover;">
                                </div>
                                @endif
                                <input type="file" name="speaker_photo" class="form-control-file" accept="image/*">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto.</small>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Link WhatsApp Group Peserta</label>
                                <input type="url" name="wa_group_url" class="form-control" value="{{ old('wa_group_url', $webinar->wa_group_url) }}" placeholder="https://chat.whatsapp.com/...">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Harga All-Access Pass (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="all_access_price" class="form-control" value="{{ old('all_access_price', $webinar->all_access_price) }}" required min="0">
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Harga Coret All-Access (Rp)</label>
                                <input type="number" name="all_access_original_price" class="form-control" value="{{ old('all_access_original_price', $webinar->all_access_original_price) }}" min="0">
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Status Webinar <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="active" {{ $webinar->status === 'active' ? 'selected' : '' }}>Aktif (Tampil di Landing Page)</option>
                                    <option value="draft" {{ $webinar->status === 'draft' ? 'selected' : '' }}>Draft (Sembunyikan)</option>
                                    <option value="closed" {{ $webinar->status === 'closed' ? 'selected' : '' }}>Tutup Pendaftaran</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-2">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fa fa-save mr-1"></i> Perbarui Data Chapter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-0">Daftar Episode Materi</h4>
                        <p class="text-muted small mb-0">Setiap episode dapat diatur gratis/donasi (wajib screenshot IG) atau berbayar</p>
                    </div>
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalAddEpisode">
                        <i class="fa fa-plus mr-1"></i> Tambah Episode Baru
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th width="70">No</th>
                                    <th>Judul Episode</th>
                                    <th>Jadwal Pelaksanaan</th>
                                    <th>Tipe & Harga</th>
                                    <th>Syarat IG</th>
                                    <th>Voucher Asesmen</th>
                                    <th>Status</th>
                                    <th class="text-center" width="130">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($webinar->episodes as $ep)
                                <tr>
                                    <td class="font-weight-bold text-center">Ep {{ $ep->episode_number }}</td>
                                    <td>
                                        <strong>{{ $ep->title }}</strong>
                                        <div class="text-muted small">{{ $ep->description }}</div>
                                    </td>
                                    <td class="small">
                                        <div><i class="fa fa-calendar mr-1 text-primary"></i> {{ $ep->date_label ?: '-' }}</div>
                                        <div><i class="fa fa-clock mr-1 text-primary"></i> {{ $ep->time_label ?: '-' }}</div>
                                    </td>
                                    <td>
                                        @if($ep->pricing_type === 'free_donation')
                                            <span class="badge badge-success px-2 py-1">Gratis / Donasi</span>
                                        @else
                                            <strong class="text-primary d-block">Rp {{ number_format($ep->price, 0, ',', '.') }}</strong>
                                            @if($ep->original_price)
                                                <small class="text-muted"><strike>Rp {{ number_format($ep->original_price, 0, ',', '.') }}</strike></small>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($ep->requires_ig_proof)
                                            <span class="badge badge-info"><i class="fa fa-check"></i> Wajib Follow IG</span>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($ep->assessment_voucher_included)
                                            <span class="badge badge-primary"><i class="fa fa-check"></i> Termasuk</span>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $ep->status === 'active' ? 'success' : 'danger' }}">
                                            {{ ucfirst($ep->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditEpisode{{ $ep->id }}">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <form action="{{ route('admin.webinar.episode.destroy', [$webinar->id, $ep->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus episode ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modalEditEpisode{{ $ep->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.webinar.episode.update', [$webinar->id, $ep->id]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title font-weight-bold">Edit Episode {{ $ep->episode_number }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body text-left">
                                                    <div class="row">
                                                        <div class="col-md-3 form-group">
                                                            <label class="font-weight-bold">No. Episode <span class="text-danger">*</span></label>
                                                            <input type="number" name="episode_number" class="form-control" value="{{ $ep->episode_number }}" required min="1">
                                                        </div>
                                                        <div class="col-md-9 form-group">
                                                            <label class="font-weight-bold">Judul Episode <span class="text-danger">*</span></label>
                                                            <input type="text" name="title" class="form-control" value="{{ $ep->title }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Deskripsi Episode</label>
                                                        <textarea name="description" rows="2" class="form-control">{{ $ep->description }}</textarea>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 form-group">
                                                            <label class="font-weight-bold">Label Tanggal</label>
                                                            <input type="text" name="date_label" class="form-control" value="{{ $ep->date_label }}" placeholder="Contoh: Jumat, 15 November 2026">
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label class="font-weight-bold">Label Jam</label>
                                                            <input type="text" name="time_label" class="form-control" value="{{ $ep->time_label }}" placeholder="Contoh: 19.30 – 21.00 WIB">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4 form-group">
                                                            <label class="font-weight-bold">Skema Harga <span class="text-danger">*</span></label>
                                                            <select name="pricing_type" class="form-control" required>
                                                                <option value="free_donation" {{ $ep->pricing_type === 'free_donation' ? 'selected' : '' }}>Gratis / Donasi Seikhlasnya</option>
                                                                <option value="paid" {{ $ep->pricing_type === 'paid' ? 'selected' : '' }}>Berbayar (Tiket Reguler)</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label class="font-weight-bold">Harga Tiket (Rp) <span class="text-danger">*</span></label>
                                                            <input type="number" name="price" class="form-control" value="{{ $ep->price }}" required min="0">
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label class="font-weight-bold">Harga Coret (Rp)</label>
                                                            <input type="number" name="original_price" class="form-control" value="{{ $ep->original_price }}" min="0">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Fasilitas / Poin Manfaat (1 baris = 1 poin)</label>
                                                        <textarea name="features" rows="4" class="form-control">{{ is_array($ep->features) ? implode("\n", $ep->features) : $ep->features }}</textarea>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="custom-control custom-checkbox mb-2">
                                                                <input type="checkbox" name="requires_ig_proof" class="custom-control-input" id="checkIg{{ $ep->id }}" {{ $ep->requires_ig_proof ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="checkIg{{ $ep->id }}">Wajib upload bukti screenshot follow IG @jatidiri.app</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="custom-control custom-checkbox mb-2">
                                                                <input type="checkbox" name="assessment_voucher_included" class="custom-control-input" id="checkVoucher{{ $ep->id }}" {{ $ep->assessment_voucher_included ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="checkVoucher{{ $ep->id }}">Sudah termasuk 1x Voucher Asesmen Minat Bakat</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        Belum ada episode materi. Silakan klik tombol "+ Tambah Episode Baru" di atas.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddEpisode" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.webinar.episode.store', $webinar->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Tambah Episode Materi Baru</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body text-left">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label class="font-weight-bold">No. Episode <span class="text-danger">*</span></label>
                            <input type="number" name="episode_number" class="form-control" value="{{ count($webinar->episodes) + 1 }}" required min="1">
                        </div>
                        <div class="col-md-9 form-group">
                            <label class="font-weight-bold">Judul Episode <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required placeholder="Contoh: Mengurai Benang Kusut Overthinking">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Deskripsi Episode</label>
                        <textarea name="description" rows="2" class="form-control" placeholder="Ringkasan materi yang akan dipelajari pada episode ini..."></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Label Tanggal</label>
                            <input type="text" name="date_label" class="form-control" placeholder="Contoh: Jumat, 15 November 2026">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Label Jam</label>
                            <input type="text" name="time_label" class="form-control" placeholder="Contoh: 19.30 – 21.00 WIB">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold">Skema Harga <span class="text-danger">*</span></label>
                            <select name="pricing_type" class="form-control" required>
                                <option value="free_donation">Gratis / Donasi Seikhlasnya</option>
                                <option value="paid">Berbayar (Tiket Reguler)</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold">Harga Tiket (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control" value="0" required min="0">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold">Harga Coret (Rp)</label>
                            <input type="number" name="original_price" class="form-control" placeholder="Opsional">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Fasilitas / Poin Manfaat (1 baris = 1 poin)</label>
                        <textarea name="features" rows="4" class="form-control" placeholder="Akses Live Zoom&#10;E-Certificate Resmi&#10;E-Workbook PDF"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" name="requires_ig_proof" class="custom-control-input" id="checkAddIg" checked>
                                <label class="custom-control-label" for="checkAddIg">Wajib upload bukti screenshot follow IG @jatidiri.app</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" name="assessment_voucher_included" class="custom-control-input" id="checkAddVoucher">
                                <label class="custom-control-label" for="checkAddVoucher">Sudah termasuk 1x Voucher Asesmen Minat Bakat</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah Episode</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

