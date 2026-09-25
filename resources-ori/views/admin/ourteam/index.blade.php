@extends('layouts.app', ['title' => 'Our Teams'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @foreach ($ourteamopenings as $oto)
                    <div class="title-section">
                        <h4 class="text-center">{!!$oto->title!!}</h4>
                        <div class="text-center mt-2">{!!$oto->description!!}</div>
                        <div class="btn-center mt-4">
                            <div class="flex">
                                <a href="{{ route('admin.ourteamopening.edit', $oto->id) }}" class="btn btn-primary btn btn-rounded"><span class="btn-icon-left text-primary"><i class="fa-solid fa-pen-to-square"></i></span>Edit Title</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-body">
                    <div class="row justify-content-between">
                        <div class="col-sm-6">
                            <a href="{{ route('admin.ourteam.create') }}" class="btn btn-primary btn btn-rounded"><span class="btn-icon-left text-primary"><i class="fa-solid fa-pen-to-square"></i></span>Add Ourteam</a>
                        </div>
                        <div class="col-sm-6">
                            <form action="{{ route('admin.ourteam.index') }}" method="GET" class="d-flex">
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
                                @forelse($ourteams as $ourteam)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>
                                        <h6>{{ $ourteam->name }} | {{ $ourteam->title }}</h6>
                                        <div>+62{{ $ourteam->phone }} | {{ $ourteam->email }}</div>
                                        <div class="flex mt-4">
                                            <a href="{{ route('admin.ourteam.edit', $ourteam->id) }}" class="badge badge-primary mr-2 badge-rounded">Edit</a>
                                            <a onClick="destroy(this.id)" id="{{ $ourteam->id }}" class="badge badge-danger badge-rounded text-white">Delete</a>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{asset('storage/ourteams/'.$ourteam->image)}}" class="admin-index-image">
                                    </td>
                                </tr>
                                @empty
                                <div class="bg-red text-white text-center">
                                    Data Belum Tersedia!
                                </div>
                                @endforelse
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                {{ $ourteams->links() }}
                            </ul>
                        </nav>
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
                    url: `/admin/ourteam/${id}`,
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