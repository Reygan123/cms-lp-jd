@extends('layouts.app', ['title' => 'Supports'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-sm-6">
                                <a href="{{ route('admin.dukungan.create') }}" class="btn btn-primary btn-rounded">
                                    <span class="btn-icon-left text-primary"><i
                                            class="fa-solid fa-pen-to-square"></i></span>Add Supports
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <form action="{{ route('admin.dukungan.index') }}" method="GET" class="d-flex">
                                    <input class="form-control input-rounded" type="text" name="q"
                                        value="{{ request()->query('q') }}" placeholder="Search" aria-label="Search">
                                    <button class="btn btn-primary btn-rounded ml-4" type="submit">Search</button>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive mt-4">
                            <table class="table table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select-all"></th>
                                        <th>Description</th>
                                        <th>Image</th>
                                        <th>Video</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($dukungans as $dukungan)
                                        <tr>
                                            <th>
                                                <input type="checkbox" name="dukungans[]" value="{{ $dukungan->id }}">
                                            </th>
                                            <td>
                                                <h6>{{ $dukungan->title }}</h6>
                                                <div>{{ $dukungan->name }} | {{ $dukungan->jabatan }}</div>
                                                <div class="flex mt-4">
                                                    <a href="{{ route('admin.dukungan.edit', $dukungan->id) }}"
                                                        class="badge badge-primary mr-2 badge-rounded">Edit</a>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($dukungan->image && file_exists(public_path('storage/dukungans/' . $dukungan->image)))
                                                    <img src="{{ asset('storage/dukungans/' . $dukungan->image) }}"
                                                        alt="{{ $dukungan->title }}" class="admin-index-image">
                                                @else
                                                    <img src="{{ asset('storage/identities/no_image.jpg') }}"
                                                        class="admin-edit-image">
                                                @endif
                                            </td>
                                            <td>
                                                <iframe id="ytplayer" type="text/html" width="100%" height="100"
                                                    src="http://www.youtube.com/embed/{{ $dukungan->id_yt }}" frameborder="0" allowfullscreen></iframe>
                                            </td>
                                        </tr>
                                    @empty
                                        <div class="bg-red text-white text-center">
                                            Data Belum Tersedia!
                                        </div>
                                    @endforelse
                                </tbody>
                            </table>

                            <div class="mt-4">
                                <button id="delete-selected" class="btn btn-danger btn-rounded mx-4">
                                    Delete Selected <span class="btn-icon-right"><i
                                            class="fa-solid fa-trash-can"></i></span>
                                </button>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        {{ $dukungans->links() }}
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Select all checkboxes
        document.getElementById('select-all').onclick = function() {
            var checkboxes = document.getElementsByName('dukungans[]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        }

        // Ajax delete selected
        document.getElementById('delete-selected').onclick = function() {
            var selecteddukungans = [];
            var checkboxes = document.getElementsByName('dukungans[]');
            var token = document.querySelector("meta[name='csrf-token']").getAttribute("content");

            for (var checkbox of checkboxes) {
                if (checkbox.checked) {
                    selecteddukungans.push(checkbox.value);
                }
            }

            if (selecteddukungans.length > 0) {
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
                        jQuery.ajax({
                            url: '{{ route('admin.dukungan.massDestroy') }}',
                            data: {
                                "ids": selecteddukungans,
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
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'PILIH DATA!',
                    text: 'PILIH DATA YANG INGIN DIHAPUS!',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        }
    </script>
@endsection
