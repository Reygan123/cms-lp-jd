@extends('layouts.app', ['title' => 'Masalah Services'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-question-circle"></i> MASALAH SERVICES
                        </h6>
                    </div>

                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <form action="{{ route('admin.masalah-service.index') }}" method="GET" id="filterForm"
                                    class="form-inline">
                                    <div class="form-group mr-2 mb-2" style="width: 200px;">
                                        <select name="service_id" class="form-control select2" id="serviceFilter">
                                            <option value="">-- Semua Service --</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}"
                                                    {{ request('service_id') == $service->id ? 'selected' : '' }}>
                                                    {{ $service->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mr-2 mb-2" style="width: 250px;">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search..." value="{{ request('search') }}" id="searchInput">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-4 text-right">
                                <div class="btn-group" role="group">
                                    <button id="delete-selected" class="btn btn-danger mr-2">
                                        <i class="fas fa-trash"></i> DELETE
                                    </button>
                                    <a href="{{ route('admin.masalah-service.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus-circle"></i> ADD NEW
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="3%">
                                            <input type="checkbox" id="select-all">
                                        </th>
                                        <th scope="col" style="width: 5%">No.</th>
                                        <th scope="col">Service</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Image</th>
                                        <th scope="col" style="width: 15%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($masalahServices as $no => $masalahService)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="checkbox" value="{{ $masalahService->id }}">
                                            </td>
                                            <th scope="row">
                                                {{ ++$no + ($masalahServices->currentPage() - 1) * $masalahServices->perPage() }}
                                            </th>
                                            <td>{{ $masalahService->service->name }}</td>
                                            <td>{{ $masalahService->title }}</td>
                                            <td>
                                                @if ($masalahService->image)
                                                    <img src="{{ asset('storage/masalah-services/' . $masalahService->image) }}"
                                                        width="100">
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.masalah-service.edit', $masalahService->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <button onclick="deleteItem({{ $masalahService->id }})"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <div class="alert alert-danger">
                                                    No Data Available!
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $masalahServices->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#serviceFilter').change(function() {
                $('#filterForm').submit();
            });

            var searchTimer;
            $('#searchInput').keyup(function() {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(function() {
                    $('#filterForm').submit();
                }, 800);
            });

            $('#select-all').click(function() {
                $('.checkbox').prop('checked', this.checked);
            });
        });

        function deleteItem(id) {
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
                    $.ajax({
                        url: `/admin/masalah-service/${id}`,
                        type: "DELETE",
                        data: {
                            "_token": token,
                        },
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
                                });
                            }
                        }
                    });
                }
            })
        }

        $('#delete-selected').click(function() {
            var selectedIds = [];
            $('.checkbox:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length > 0) {
                var token = $("meta[name='csrf-token']").attr("content");

                Swal.fire({
                    title: 'APAKAH KAMU YAKIN ?',
                    text: "INGIN MENGHAPUS DATA YANG DIPILIH!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'BATAL',
                    confirmButtonText: 'YA, HAPUS!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.masalah-service.massDestroy') }}",
                            type: "DELETE",
                            data: {
                                "ids": selectedIds,
                                "_token": token,
                            },
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
        });
    </script>
@endsection
