@extends('layouts.app', ['title' => 'Supports'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-right">Edit</h5>
                        <form action="{{ route('admin.dukungan.update', $dukungan->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group mb-4">
                                                <label class="text-label" for="title">Support's Title</label>
                                                <input type="text" class="form-control" name="title"
                                                    value="{{ old('title', $dukungan->title) }}">
                                                @error('title')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-4">
                                                <label class="text-label" for="name">Full Name</label>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ old('name', $dukungan->name) }}">
                                                @error('name')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-4">
                                                <label class="text-label" for="jabatan">Title</label>
                                                <input type="text" class="form-control" name="jabatan"
                                                    value="{{ old('jabatan', $dukungan->jabatan) }}">
                                                @error('jabatan')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-2 mt-4">
                                                @if ($dukungan->image)
                                                    <img src="{{ asset('storage/dukungans/' . $dukungan->image) }}"
                                                        alt="{{ $dukungan->name }}" class="admin-edit-image">
                                                @else
                                                    <img src="{{ asset('storage/identities/no_image.jpg') }}"
                                                        class="admin-edit-image">
                                                @endif
                                            </div>
                                            <div class="mb-2 mt-4">
                                                <label class="text-gray-700" for="image">Gambar (Max Size: 750kb)</label>
                                                <input type="file" class="dropify" data-default-file="" id="image"
                                                    name="image" />
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
                                                    src="https://www.youtube.com/embed/{{ $dukungan->id_yt }}" frameborder="0"
                                                    allowfullscreen></iframe>
                                            </div>
                                            <div class="form-group">
                                                <label class="text-label" for="id_yt">ID Video Youtube</label>
                                                <input class="form-control" type="text" name="id_yt"
                                                    value="{{ old('title', $dukungan->id_yt) }}"
                                                    placeholder="ID Youtube">
                                                @error('id_yt')
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
                                <button type="submit" class="btn btn-primary">UPDATE</button>
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

        function updateYouTubePreview(id_yt) {
            if (id_yt) {
                $('#ytplayer').attr('src', 'http://www.youtube.com/embed/' + id_yt); // Updated to embed URL
            } else {
                $('#ytplayer').attr('src', ''); // Clear the iframe if the input is empty
            }
        }
    </script>
@endsection
