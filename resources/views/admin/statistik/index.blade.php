@extends('layouts.app', ['title' => 'Statistik'])

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-bar"></i> STATISTIK
                    </h6>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <a href="{{ route('admin.statistik.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i> ADD NEW
                            </a>
                            <button id="delete-selected" class="btn btn-danger ml-2">
                                <i class="fas fa-trash"></i> DELETE SELECTED
                            </button>
                        </div>

                        <div class="col-md-6">
                            <form action="{{ route('admin.statistik.index') }}" method="GET" class="form-inline float-right">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
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
                                    <th scope="col">Pengguna</th>
                                    <th scope="col">Assesmen</th>
                                    <th scope="col">Psikologi</th>
                                    <th scope="col">Konselor</th>
                                    <th scope="col" style="width: 15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($statistiks as $no => $statistik)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkbox" value="{{ $statistik->id }}">
                                    </td>
                                    <th scope="row">
                                        {{ ++$no + ($statistiks->currentPage()-1) * $statistiks->perPage() }}
                                    </th>
                                    <td>{{ number_format($statistik->pengguna) }}</td>
                                    <td>{{ number_format($statistik->assesmen) }}</td>
                                    <td>{{ number_format($statistik->psikologi) }}</td>
                                    <td>{{ number_format($statistik->konselor) }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.statistik.edit', $statistik->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <button onclick="deleteItem({{ $statistik->id }})" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">
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
                        {{ $statistiks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Select all checkbox
        $('#select-all').click(function() {
            $('.checkbox').prop('checked', this.checked);
        });
    });

    // Delete single item
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
                    url: `/admin/statistik/${id}`,
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
                        }
                    }
                });
            }
        })
    }

    // Delete selected items
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
                        url: "{{ route('admin.statistik.massDestroy') }}",
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
