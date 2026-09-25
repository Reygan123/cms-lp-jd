@extends('layouts.app', ['title' => 'Programs'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-between">
                        <div class="col-sm-6 mt-4">
                            <a href="{{ route('admin.program.create.halaman-pertama') }}" class="btn btn-primary btn-rounded">
                                <span class="btn-icon-left text-primary"><i class="fa-solid fa-pen-to-square"></i></span>Add Program
                            </a>
                        </div>
                        <div class="col-sm-6 mt-4">
                            <form action="{{ route('admin.program.index') }}" method="GET" class="d-flex">
                                <input class="form-control input-rounded" type="text" name="q" value="{{ request()->query('q') }}" placeholder="Search" aria-label="Search">
                                <button class="btn btn-primary btn-rounded ml-4" type="submit">Search</button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-responsive-sm">
                            <thead>
                                <tr>
                                    <th style="width: 20px;"><input type="checkbox" id="select-all"></th>
                                    <th>Title & Description</th>
                                    <th style="width: 200px;" class="d-none d-md-block">Image</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($programs as $program)
                                <tr>
                                    <th>
                                        <input type="checkbox" name="programs[]" value="{{ $program->id }}">
                                    </th>
                                    <td>
                                        <h5>{{ $program->name }}</h5>
                                        <!-- <div class="mt-2">
                                            <div class="row">
                                                <div class="col-md-3 col-sm-6"><i class="fa-solid fa-calendar-check"></i> {{ $program->age }} years old</div>
                                                <div class="col-md-3 col-sm-6"><i class="fa-solid fa-calendar-days"></i> {{ $program->weekly }} days in a week</div>
                                                <div class="col-md-3 col-sm-6"><i class="fa-solid fa-clock-rotate-left"></i> {{ $program->periode }} hours in a day</div>
                                                <div class="col-md-3 col-sm-6"><i class="fa-solid fa-people-roof"></i> {{ $program->class_size }} students in a class</div>
                                            </div>
                                        </div> -->
                                        <div class="flex mt-4">
                                            <a href="{{ route('admin.program.edit.halaman-pertama', $program->id) }}" class="badge badge-primary mr-2 badge-rounded">Edit</a>
                                        </div>
                                    </td>
                                    <td class="d-none d-md-block">
                                        @if ($program->image1 && file_exists(public_path('storage/programs/' . $program->image1)))
                                                    <img src="{{ asset('storage/programs/' . $program->image1) }}"
                                                        alt="{{ $program->name }}" class="admin-index-image">
                                                @else
                                                    <img src="{{ asset('storage/identities/no_image.jpg') }}"
                                                        class="admin-edit-image">
                                                @endif
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
                                Delete Selected <span class="btn-icon-right"><i class="fa-solid fa-trash-can"></i></span>
                            </button>
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    {{ $programs->links() }}
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
        var checkboxes = document.getElementsByName('programs[]');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    }

    // Ajax delete selected
    document.getElementById('delete-selected').onclick = function() {
        var selectedPrograms = [];
        var checkboxes = document.getElementsByName('programs[]');
        var token = document.querySelector("meta[name='csrf-token']").getAttribute("content");

        for (var checkbox of checkboxes) {
            if (checkbox.checked) {
                selectedPrograms.push(checkbox.value);
            }
        }

        if (selectedPrograms.length > 0) {
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
                        url: '{{ route("admin.program.massDestroy") }}',
                        data: {
                            "ids": selectedPrograms,
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
