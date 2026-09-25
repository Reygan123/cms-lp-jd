@extends('layouts.app', ['title' => 'Testimony'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-right">Create</h5>
                        <form action="{{ route('admin.testimony.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group mb-4">
                                                <input type="checkbox" name="home" id="home" value="1" {{ old('home') ? 'checked' : '' }}>
                                                <label for="home"> Display on Homepage</label>
                                                @error('home')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label class="text-label" for="program_id">Program Name</label>
                                                <select class="form-control" name="program_id">
                                                    @foreach ($programs as $program)
                                                        <option class="py-1" value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                                                            {{ $program->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('program_id')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label class="text-label" for="name">Name</label>
                                                <input class="form-control" type="text" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap">
                                                @error('name')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label class="text-label" for="title">Title</label>
                                                <input class="form-control" type="text" name="title" value="{{ old('title') }}" placeholder="Jabatan">
                                                @error('title')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label class="text-label" for="description">Testimony Description</label>
                                                <textarea id="editor1" name="description" rows="15">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-2 mt-4">
                                                <img src="{{ asset('storage/identities/no_image.jpg') }}" class="admin-edit-image" id="image-preview">
                                            </div>

                                            <div class="mb-2 mt-4">
                                                <label class="text-gray-700" for="image">Gambar (Max Size: 750kb)</label>
                                                <input type="file" class="dropify" data-default-file="" id="image" name="image" accept="image/*" onchange="previewImage(this);" />
                                                @error('image')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="form-group mt-4">
                                                <iframe id="ytplayer" type="text/html" width="100%" height="300"
                                                    src="" frameborder="0" allowfullscreen></iframe>
                                            </div>

                                            <div class="form-group">
                                                <label class="text-label" for="yt_link">ID Video Youtube</label>
                                                <input class="form-control" type="text" name="yt_link" value="{{ old('yt_link') }}" placeholder="ID Youtube" oninput="updateYouTubePreview(this.value)">
                                                @error('yt_link')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-start mt-4">
                                <button type="submit" class="btn btn-primary">SAVE</button>
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

        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#image-preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function updateYouTubePreview(yt_link) {
            if (yt_link) {
                $('#ytplayer').attr('src', 'http://www.youtube.com/embed/' + yt_link); // Updated to embed URL
            } else {
                $('#ytplayer').attr('src', ''); // Clear the iframe if the input is empty
            }
        }
    </script>
@endsection