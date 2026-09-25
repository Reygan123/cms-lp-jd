@extends('layouts.app', ['title' => 'Features'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-between mb-4">
                            <div class="col-sm-6">
                                <a href="{{ route('admin.unggulan.create') }}" class="btn btn-primary btn-rounded">
                                    <span class="btn-icon-left text-primary"><i class="fa-solid fa-pen-to-square"></i></span>
                                    Add Features
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <form action="{{ route('admin.unggulan.index') }}" method="GET" class="d-flex">
                                    <input class="form-control input-rounded" type="text" name="q"
                                           value="{{ request()->query('q') }}" placeholder="Search" aria-label="Search">
                                    <button class="btn btn-primary btn-rounded ml-4" type="submit">Search</button>
                                </form>
                            </div>
                        </div>

                        <div class="default-tab">
                            <ul class="nav nav-tabs" role="tablist">
                                @php
                                    $categories = $unggulans->groupBy(function ($item) {
                                        return $item->program->name ?? 'No Category';
                                    });
                                @endphp

                                @foreach ($categories as $category => $items)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab"
                                           href="#category-{{ Str::slug($category) }}">{{ $category }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                @foreach ($categories as $category => $items)
                                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                         id="category-{{ Str::slug($category) }}" role="tabpanel">
                                        <div class="pt-4">
                                            <table class="table table-responsive-sm">
                                                @foreach ($items as $unggulan)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="unggulans[]" value="{{ $unggulan->id }}">
                                                        </td>
                                                        <td>
                                                            <h4>{{ $unggulan->title }}</h4>
                                                            <!-- {!! $unggulan->description !!} -->
                                                            <div class="mt-4">
                                                                <a href="{{ route('admin.unggulan.edit', $unggulan->id) }}"
                                                                   class="badge badge-primary mr-2 badge-rounded">Edit</a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if ($unggulan->image && file_exists(public_path('storage/unggulans/' . $unggulan->image)))
                                                                <img src="{{ asset('storage/unggulans/' . $unggulan->image) }}"
                                                                     alt="{{ $unggulan->title }}" class="admin-index-image">
                                                            @else
                                                                <img src="{{ asset('storage/identities/no_image.jpg') }}"
                                                                     class="admin-edit-image">
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                                <button id="delete-selected" class="btn btn-danger btn-rounded mx-4">
                                    Delete Selected <span class="btn-icon-right"><i class="fa-solid fa-trash-can"></i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Ajax delete selected
        document.getElementById('delete-selected').onclick = function() {
            var selectedunggulans = [];
            var checkboxes = document.getElementsByName('unggulans[]');
            var token = document.querySelector("meta[name='csrf-token']").getAttribute("content");

            for (var checkbox of checkboxes) {
                if (checkbox.checked) {
                    selectedunggulans.push(checkbox.value);
                }
            }

            if (selectedunggulans.length > 0) {
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
                            url: '{{ route('admin.unggulan.massDestroy') }}',
                            data: {
                                "ids": selectedunggulans,
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
