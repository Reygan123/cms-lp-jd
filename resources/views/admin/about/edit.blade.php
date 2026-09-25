@extends('layouts.app', ['title' => 'About Us'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-right">Edit</h5>
                        <form action="{{ route('admin.about.update', $about->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-label" for="title">Title</label>
                                        <input class="form-control" type="text" name="title"
                                            value="{{ old('title', $about->title) }}" placeholder="">
                                        @error('title')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mt-4">
                                                <label class="text-label" for="subtitle">Sub Title</label>
                                                <input class="form-control" type="text" name="subtitle"
                                                    value="{{ old('subtitle', $about->subtitle) }}" placeholder="">
                                                @error('subtitle')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mt-4">
                                                <label class="text-label" for="video">ID Video Youtube</label>
                                                <input class="form-control" type="text" name="video"
                                                    value="{{ old('video', $about->video) }}" placeholder="">
                                                @error('video')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-4">
                                        <label class="text-label" for="description">Deskripsi Singkat</label>
                                        <textarea id="editor" name="description" rows="15">{{ old('description', $about->description) }}</textarea>
                                        @error('description')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mt-4">
                                        <label class="text-label" for="content">Deskripsi Lengkap</label>
                                        <textarea id="editor1" name="content" rows="15">{{ old('content', $about->content) }}</textarea>
                                        @error('content')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-2 mt-4">
                                                <label class="text-gray-700" for="image1">Gambar (Max Size: 750kb)</label>
                                                <input type="file" class="dropify" data-default-file="" id="image1"
                                                    name="image1" />
                                                @error('image1')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-2 mt-4">
                                                @if ($about->image1 && file_exists(public_path('storage/identities/' . $about->image1)))
                                                    <img src="{{ asset('storage/identities/' . $about->image1) }}"
                                                        alt="{{ $about->title }}" class="admin-edit-logo">
                                                @else
                                                    <img src="{{ asset('storage/identities/no_image.jpg') }}"
                                                        class="admin-edit-image">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-2 mt-4">
                                                <label class="text-gray-700" for="image2">Gambar (Max Size: 750kb)</label>
                                                <input type="file" class="dropify" data-default-file="" id="image2"
                                                    name="image2" />
                                                @error('image2')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-2 mt-4">
                                                @if ($about->image2 && file_exists(public_path('storage/identities/' . $about->image2)))
                                                    <img src="{{ asset('storage/identities/' . $about->image2) }}"
                                                        alt="{{ $about->title }}" class="admin-edit-logo">
                                                @else
                                                    <img src="{{ asset('storage/identities/no_image.jpg') }}"
                                                        class="admin-edit-image">
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end mt-4">
                                <button type="submit" class="btn btn-primary">UPDATE</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
        <div class="container mx-auto px-6 py-8">

        </div>
    </main>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#editor1'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
