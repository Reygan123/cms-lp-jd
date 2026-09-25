@extends('layouts.app', ['title' => 'Important Date'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-sm-6">
                                <a href="{{ route('admin.tanggalpenting.create') }}" class="btn btn-primary btn-rounded">
                                    <span class="btn-icon-left text-primary"><i
                                            class="fa-solid fa-pen-to-square"></i></span>Add Date
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <form action="{{ route('admin.tanggalpenting.index') }}" method="GET" class="d-flex">
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
                                        <th style="width: 10px"><input type="checkbox" id="select-all"></th>
                                        <th style="width: 50px">Date</th>
                                        <th>Title & Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tanggalpentings as $tanggalpenting)
                                        <tr>
                                            <th >
                                                <input type="checkbox" name="tanggalpentings[]" value="{{ $tanggalpenting->id }}">
                                            </th>
                                            <td ><h5>{{ date('d M Y', strtotime($tanggalpenting->date)) }}</h5></td>
                                            <td>
                                                <h6>{{ $tanggalpenting->title }}</h6>
                                                {!! $tanggalpenting->description !!} 
                                                <div class="flex mt-4">
                                                    <a href="{{ route('admin.tanggalpenting.edit', $tanggalpenting->id) }}"
                                                        class="badge badge-primary mr-2 badge-rounded">Edit</a>
                                                </div>
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
                                        {{ $tanggalpentings->links() }}
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
            var checkboxes = document.getElementsByName('tanggalpentings[]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        }

        // Ajax delete selected
        document.getElementById('delete-selected').onclick = function() {
            var selectedtanggalpentings = [];
            var checkboxes = document.getElementsByName('tanggalpentings[]');
            var token = document.querySelector("meta[name='csrf-token']").getAttribute("content");

            for (var checkbox of checkboxes) {
                if (checkbox.checked) {
                    selectedtanggalpentings.push(checkbox.value);
                }
            }

            if (selectedtanggalpentings.length > 0) {
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
                            url: '{{ route('admin.tanggalpenting.massDestroy') }}',
                            data: {
                                "ids": selectedtanggalpentings,
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
