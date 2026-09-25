@extends('layouts.app', ['title' => 'Create Service'])

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-plus-circle"></i> CREATE NEW SERVICE
                    </h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.service.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NAME <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter service name" class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @for($i = 1; $i <= 4; $i++)
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h5>SECTION {{ $i }}</h5>
                                <hr>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title {{ $i }}</label>
                                    <input type="text" name="title{{ $i }}" value="{{ old('title'.$i) }}" placeholder="Enter title {{ $i }}" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image {{ $i }}</label>
                                    <input type="file" name="image{{ $i }}" id="image{{ $i }}" class="form-control" onchange="previewImage(this, 'preview{{ $i }}')">
                                    <div class="mt-2">
                                        <img id="preview{{ $i }}" src="" alt="Preview" class="img-thumbnail" style="display: none; max-width: 200px;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description {{ $i }}</label>
                                    <textarea id="editor{{ $i }}" name="description{{ $i }}" rows="3" class="form-control" placeholder="Enter description {{ $i }}">{{ old('description'.$i) }}</textarea>
                                </div>
                            </div>
                        </div>
                        @endfor

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> SAVE
                                </button>
                                <button type="reset" class="btn btn-warning">
                                    <i class="fas fa-redo"></i> RESET
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    @for($i = 1; $i <= 4; $i++)
        ClassicEditor
            .create(document.querySelector('#editor{{ $i }}'))
            .catch(error => {
                console.error(error);
            });
    @endfor

    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    }
</script>
@endsection
