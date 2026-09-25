@extends('layouts.app', ['title' => 'Edit Service'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-edit"></i> EDIT SERVICE
                        </h6>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.service.update', $service->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>NAME <span class="text-danger">*</span></label>
                                        <input type="text" name="name" value="{{ old('name', $service->name) }}"
                                            placeholder="Enter service name"
                                            class="form-control @error('name') is-invalid @enderror">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            @for ($i = 1; $i <= 4; $i++)
                                @php
                                    $title = 'title' . $i;
                                    $description = 'description' . $i;
                                    $image = 'image' . $i;
                                    $hasImage = !empty($service->$image);
                                @endphp
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h5>SECTION {{ $i }}</h5>
                                        <hr>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title {{ $i }}</label>
                                            <input type="text" name="title{{ $i }}"
                                                value="{{ old($title, $service->$title) }}"
                                                placeholder="Enter title {{ $i }}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Image {{ $i }}</label>
                                            <input type="file" name="image{{ $i }}"
                                                id="image{{ $i }}" class="form-control"
                                                onchange="previewImage(this, 'preview{{ $i }}', 'oldPreview{{ $i }}')">

                                            <div class="mt-2">
                                                <!-- Preview for new image -->
                                                <img id="preview{{ $i }}" src="" alt="New Preview"
                                                    class="img-thumbnail" style="display: none; max-width: 200px;">

                                                <!-- Existing image -->
                                                @if ($hasImage)
                                                    <div id="oldPreview{{ $i }}">
                                                        <img src="{{ asset('storage/services/' . $service->$image) }}"
                                                            width="100" class="img-thumbnail">
                                                        <p>{{ $service->$image }}</p>
                                                        <div class="mt-2">
                                                            <a href="{{ route('admin.service.delete-image', ['id' => $service->id, 'field' => $image]) }}"
                                                                class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Are you sure you want to delete this image?')">
                                                                <i class="fas fa-trash"></i> Remove Image
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description {{ $i }}</label>
                                            <textarea id="editor{{ $i }}" name="description{{ $i }}" rows="3" class="form-control"
                                                placeholder="Enter description {{ $i }}">{{ old($description, $service->$description) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endfor

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> UPDATE
                                    </button>
                                    <a href="{{ route('admin.service.index') }}" class="btn btn-warning">
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
        @for ($i = 1; $i <= 4; $i++)
            ClassicEditor
                .create(document.querySelector('#editor{{ $i }}'))
                .catch(error => {
                    console.error(error);
                });
        @endfor

        function previewImage(input, previewId, oldPreviewId) {
            const preview = document.getElementById(previewId);
            const oldPreview = document.getElementById(oldPreviewId);
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';

                    // Hide old preview when new image is selected
                    if (oldPreview) {
                        oldPreview.style.display = 'none';
                    }
                }

                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';

                // Show old preview when no file is selected
                if (oldPreview) {
                    oldPreview.style.display = 'block';
                }
            }
        }
    </script>
@endsection
