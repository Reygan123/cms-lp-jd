@extends('layouts.app', ['title' => 'Headers'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-4">
                <div class="card-body">
                    <div class="row justify-content-between">
                        <div class="col-sm-6">
                            <form action="{{ route('admin.header.index') }}" method="GET" class="d-flex">
                                <input class="form-control input-rounded" type="text" name="q" value="{{ request()->query('q') }}" placeholder="Search" aria-label="Search">
                                <button class="btn btn-primary btn-rounded ml-4" type="submit">Search</button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-responsive-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title & Description</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($headers as $header)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>
                                        <h6>{{ $header->title }}</h6>
                                        <div>{!! $header->description !!}</div>
                                        <div class="flex">
                                            <a href="{{ route('admin.header.edit', $header->id) }}" class="badge badge-primary mr-2 badge-rounded">Edit</a>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{asset('storage/headers/'.$header->image)}}" class="admin-index-image">
                                    </td>
                                </tr>
                                @empty
                                <div class="bg-red text-white text-center">
                                    Data Belum Tersedia!
                                </div>
                                @endforelse
                            </tbody>
                        </table>
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
                    url: `/admin/header/${id}`,
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