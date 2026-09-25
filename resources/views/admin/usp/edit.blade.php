@extends('layouts.app', ['title' => 'Edit USP'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-edit"></i> EDIT USP
                        </h6>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.usp.update', $usp->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>TITLE <span class="text-danger">*</span></label>
                                        <input type="text" name="title" value="{{ old('title', $usp->title) }}"
                                            placeholder="Enter title"
                                            class="form-control @error('title') is-invalid @enderror">
                                        @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>IMAGE</label>
                                        <input type="file" name="image" id="image" class="form-control"
                                            onchange="previewImage(this, 'preview', 'oldPreview')">
                                        <div class="mt-2">
                                            <!-- Preview for new image -->
                                            <img id="preview" src="" alt="New Preview" class="img-thumbnail"
                                                style="display: none; max-width: 200px;">

                                            <!-- Existing image -->
                                            @if ($usp->image)
                                                <div id="oldPreview">
                                                    <img src="{{ asset('storage/usps/' . $usp->image) }}" width="200"
                                                        class="img-thumbnail">
                                                    <p class="mt-2">{{ $usp->image }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>DESCRIPTION <span class="text-danger">*</span></label>
                                        <textarea id="editor1" name="description" rows="15"
                                            class="form-control @error('description') is-invalid @enderror">{{ old('description', $usp->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> UPDATE
                                    </button>
                                    <a href="{{ route('admin.usp.index') }}" class="btn btn-warning">
                                        <i class="fas fa-arrow-left"></i> BACK
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor1'))
            .catch(error => {
                console.error(error);
            });

        function previewImage(input, previewId, oldPreviewId) {
            const preview = document.getElementById(previewId);
            const oldPreview = document.getElementById(oldPreviewId);
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';

                    if (oldPreview) {
                        oldPreview.style.display = 'none';
                    }
                }

                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';

                if (oldPreview) {
                    oldPreview.style.display = 'block';
                }
            }
        }
    </script>
@endsection
