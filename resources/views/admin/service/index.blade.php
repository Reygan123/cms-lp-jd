@extends('layouts.app', ['title' => 'Service'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-cogs"></i> Services
                        </h6>
                    </div>

                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <a href="{{ route('admin.service.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus-circle"></i> Add New
                                </a>
                            </div>

                            <div class="col-md-6">
                                <form action="{{ route('admin.service.index') }}" method="GET">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="Search..."
                                            value="{{ request()->search }}">
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
                                        <th scope="col" style="width: 5%">No.</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Title 1</th>
                                        <th scope="col" style="width: 15%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($services as $no => $service)
                                        <tr>
                                            <th scope="row">
                                                {{ ++$no + ($services->currentPage() - 1) * $services->perPage() }}</th>
                                            <td>{{ $service->name }}</td>
                                            <td>{{ $service->title1 }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.service.edit', $service->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <button onclick="Delete(this.id)" id="{{ $service->id }}"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
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
                            {{ $services->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function Delete(id) {
            var id = id;
            var token = $("meta[name='csrf-token']").attr("content");

            swal({
                title: "ARE YOU SURE?",
                text: "WANT TO DELETE THIS SERVICE?",
                icon: "warning",
                buttons: [
                    'CANCEL',
                    'YES, DELETE!'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    jQuery.ajax({
                        url: "{{ route('admin.service.destroy', '') }}/" + id,
                        data: {
                            "id": id,
                            "_token": token
                        },
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        type: "DELETE",
                        success: function(response) {
                            if (response.status == "success") {
                                swal({
                                    title: 'SUCCESS!',
                                    text: 'SERVICE DELETED SUCCESSFULLY!',
                                    icon: 'success',
                                    timer: 3000,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            } else {
                                swal({
                                    title: 'FAILED!',
                                    text: 'FAILED TO DELETE SERVICE!',
                                    icon: 'error',
                                    timer: 3000,
                                    buttons: false,
                                });
                            }
                        },
                        error: function(xhr) {
                            swal({
                                title: 'ERROR!',
                                text: 'An error occurred while deleting.',
                                icon: 'error',
                                timer: 3000,
                                buttons: false,
                            });
                        }
                    });
                }
            });
        }
    </script>
@endsection
