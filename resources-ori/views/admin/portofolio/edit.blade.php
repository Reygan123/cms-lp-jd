@extends('layouts.app', ['title' => 'Portfolio'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-right">Edit</h5>
                        <form action="{{ route('admin.portofolio.update', $portofolio->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-4">
                                                <input type="checkbox" name="home" id="home" value="1"
                                                    {{ old('home', $portofolio->home) ? 'checked' : '' }}>
                                                <label for="home"> Display on Homepage</label>
                                                @error('home')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mb-4">
                                                <label class="text-label" for="program_id">Program Name</label>
                                                <select class="form-control" name="program_id">
                                                    @foreach ($programs as $program)
                                                        <option class="py-1" value="{{ $program->id }}"
                                                            @if ($portofolio->program_id == $program->id) selected @endif>
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
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label class="text-label" for="title">Title</label>
                                        <input type="text" class="form-control" name="title"
                                            value="{{ old('title', $portofolio->title) }}">
                                        @error('title')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-4">
                                        <label class="text-label" for="name">Description</label>
                                        <textarea id="editor1" name="description" rows="15">{{ old('description', $portofolio->description) }}</textarea>
                                        @error('description')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label class="text-label" for="yt_id">Video Youtube ID</label>
                                            <div class="form-group mb-4">
                                                @if ($portofolio->yt_id)
                                                    <iframe id="ytplayer" type="text/html" width="100%" height="300"
                                                        src="https://www.youtube.com/embed/{{ $portofolio->yt_id }}"
                                                        frameborder="0" allowfullscreen></iframe>
                                                @else
                                                @endif
                                            </div>
                                            <div class="form-group mb-4">
                                                <input type="text" class="form-control" name="yt_id"
                                                    value="{{ old('yt_id') }}" placeholder="e.g: guLwhWOImVs">
                                                @error('yt_id')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group mb-4">
                                                <label class="text-gray-700" for="logo">Logo <small>(Max Size:
                                                        750kb)</small></label>
                                                @if ($portofolio->logo)
                                                    <img src="{{ asset('storage/portofolios/' . $portofolio->logo) }}"
                                                        alt="{{ $portofolio->title }}" class="admin-edit-image">
                                                @else
                                                    <img src="{{ asset('storage/identities/no_image.jpg') }}"
                                                        class="admin-edit-image">
                                                @endif
                                                <div class="mt-4">
                                                    <input type="file" class="dropify" id="logo" name="logo" />
                                                    @error('logo')
                                                        <div
                                                            class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                            <div class="px-4 py-2">
                                                                <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                            </div>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group mb-4">
                                                <label class="text-gray-700" for="image1">Image 1 <small>(Max Size:
                                                        750kb)</small></label>
                                                @if ($portofolio->image1)
                                                    <img src="{{ asset('storage/portofolios/' . $portofolio->image1) }}"
                                                        alt="{{ $portofolio->title }}" class="admin-edit-image">
                                                @else
                                                    <img src="{{ asset('storage/identities/no_image.jpg') }}"
                                                        class="admin-edit-image">
                                                @endif
                                                <div class="mt-4">
                                                    <input type="file" class="dropify" id="image1" name="image1" />
                                                    @error('image1')
                                                        <div
                                                            class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                            <div class="px-4 py-2">
                                                                <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                            </div>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group mb-4">
                                                <label class="text-gray-700" for="image2">Image 2 <small>(Max Size:
                                                        750kb)</small></label>
                                                @if ($portofolio->image2)
                                                    <img src="{{ asset('storage/portofolios/' . $portofolio->image2) }}"
                                                        alt="{{ $portofolio->title }}" class="admin-edit-image">
                                                @else
                                                    <img src="{{ asset('storage/identities/no_image.jpg') }}"
                                                        class="admin-edit-image">
                                                @endif
                                                <div class="mt-4">
                                                    <input type="file" class="dropify" id="image2"
                                                        name="image2" />
                                                    @error('image2')
                                                        <div
                                                            class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                            <div class="px-4 py-2">
                                                                <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                            </div>
                                                        </div>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group mb-4">
                                                <label class="text-gray-700" for="image3">Image 3 <small>(Max Size:
                                                        750kb)</small></label>
                                                @if ($portofolio->image3)
                                                    <img src="{{ asset('storage/portofolios/' . $portofolio->image3) }}"
                                                        alt="{{ $portofolio->title }}" class="admin-edit-image">
                                                @else
                                                    <img src="{{ asset('storage/identities/no_image.jpg') }}"
                                                        class="admin-edit-image">
                                                @endif
                                                <div class="mt-4">
                                                    <input type="file" class="dropify" id="image3"
                                                        name="image3" />
                                                    @error('image3')
                                                        <div
                                                            class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                            <div class="px-4 py-2">
                                                                <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                            </div>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group mb-4">
                                                <label class="text-gray-700" for="image4">Image 4 <small>(Max Size:
                                                        750kb)</small></label>
                                                @if ($portofolio->image4)
                                                    <img src="{{ asset('storage/portofolios/' . $portofolio->image4) }}"
                                                        alt="{{ $portofolio->title }}" class="admin-edit-image">
                                                @else
                                                    <img src="{{ asset('storage/identities/no_image.jpg') }}"
                                                        class="admin-edit-image">
                                                @endif
                                                <div class="mt-4">
                                                    <input type="file" class="dropify" id="image4"
                                                        name="image4" />
                                                    @error('image4')
                                                        <div
                                                            class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
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
    </script>
@endsection
