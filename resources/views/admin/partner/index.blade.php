@extends('layouts.app', ['title' => 'Partners'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-4">
                <div class="card-body">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md-4 col-sm-12 mb-2">
                            <a href="{{ route('admin.partner.create') }}" class="btn btn-primary btn btn-rounded"><span class="btn-icon-left text-primary"><i class="fa-solid fa-pen-to-square"></i></span>Add Partner</a>
                        </div>
                        <div class="col-md-8 col-sm-12 mb-2">
                            <form action="{{ route('admin.partner.index') }}" method="GET" class="d-flex flex-wrap justify-content-md-end">
                                <select name="category" class="form-control input-rounded mr-2 mb-2" style="max-width: 170px;" onchange="this.form.submit()">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($categories as $catKey => $catLabel)
                                        <option value="{{ $catKey }}" {{ request('category') == $catKey ? 'selected' : '' }}>{{ $catLabel }}</option>
                                    @endforeach
                                </select>
                                <input class="form-control input-rounded mr-2 mb-2" style="max-width: 220px;" type="text" name="q" value="{{ request()->query('q') }}" placeholder="Cari nama partner..." aria-label="Search">
                                <button class="btn btn-primary btn-rounded mb-2" type="submit">Search</button>
                                @if(request('q') || request('category') || request('level'))
                                    <a href="{{ route('admin.partner.index') }}" class="btn btn-light btn-rounded ml-2 mb-2">Reset</a>
                                @endif
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-responsive-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title & Description</th>
                                    <th>Kategori & Level</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($partners as $partner)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>
                                        <h6><a href="{{ $partner->web }}" target="_blank">{{ $partner->name }}</a></h6>
                                        <div>{!! $partner->description !!}</div>
                                        <div class="flex mt-4">
                                            <a href="{{ route('admin.partner.edit', $partner->id) }}" class="badge badge-primary mr-2 badge-rounded">Edit</a>
                                            <a onClick="destroy(this.id)" id="{{ $partner->id }}" class="badge badge-danger badge-rounded text-white" style="cursor: pointer;">Delete</a>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $catBadgeClass = match($partner->category) {
                                                'sekolah' => 'badge-info',
                                                'corporate' => 'badge-success',
                                                'kampus' => 'badge-warning',
                                                'komunitas' => 'badge-secondary',
                                                default => 'badge-dark'
                                            };
                                        @endphp
                                        <div>
                                            <span class="badge {{ $catBadgeClass }} badge-rounded">
                                                {{ \App\Models\Partner::CATEGORIES[$partner->category] ?? ucfirst($partner->category ?? 'Sekolah') }}
                                            </span>
                                        </div>
                                        @if($partner->level)
                                            <div class="mt-2">
                                                <span class="badge badge-outline-primary badge-rounded">
                                                    {{ $partner->level }}
                                                </span>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <img src="{{ Str::startsWith($partner->image, 'http') ? $partner->image : asset('storage/partners/'.$partner->image) }}" class="admin-index-image">
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <div class="alert alert-warning mb-0">
                                            Data Belum Tersedia!
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        {{ $partners->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    //ajax delete
    function destroy(id) {
        var id = id;
        var token = $("meta[name='csrf-token']").attr("content");

        Swal.fire({
            title: 'APAKAH KAMU YAKIN ?',
            text: "INGIN MENGHAPUS DATA INI!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'BATAL',
            confirmButtonText: 'YA, HAPUS!',
        }).then((result) => {
            if (result.isConfirmed) {
                //ajax delete
                jQuery.ajax({
                    url: `/admin/partner/${id}`,
                    data: {
                        "id": id,
                        "_token": token
                    },
                    type: 'DELETE',
                    success: function(response) {
                        if (response.status == "success") {
                            Swal.fire({
                                icon: 'success',
                                title: 'BERHASIL!',
                                text: 'DATA BERHASIL DIHAPUS!',
                                showConfirmButton: false,
                                timer: 3000
                            }).then(function() {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'GAGAL!',
                                text: 'DATA GAGAL DIHAPUS!',
                                showConfirmButton: false,
                                timer: 3000
                            }).then(function() {
                                location.reload();
                            });
                        }
                    }
                });
            }
        })
    }
</script>
@endsection