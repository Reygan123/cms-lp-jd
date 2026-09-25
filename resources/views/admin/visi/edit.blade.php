@extends('layouts.app', ['title' => 'Visi'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-right">Edit</h5>
                    <form action="{{ route('admin.visi.update', $visi->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="text-label" for="title">Title</label>
                                    <input class="form-control" type="text" name="title" value="{{ old('title', $visi->title) }}">
                                    @error('title')
                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                        <div class="px-4 py-2">
                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                        </div>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="text-label" for="subtitle">Subtitle</label>
                                    <input class="form-control" type="text" name="subtitle" value="{{ old('subtitle', $visi->subtitle) }}">
                                    @error('subtitle')
                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                        <div class="px-4 py-2">
                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                        </div>
                                    </div>
                                    @enderror
                                </div>
                                <div>
                                    <label class="text-gray-700" for="visi">Vision Statement</label>
                                    <textarea id="editor" name="visi" rows="15">{{ old('visi', $visi->visi) }}</textarea>
                                    @error('visi')
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
                                            <label class="text-gray-700" for="image">Gambar (Max Size: 750kb)</label>
                                            <input type="file" class="dropify" data-default-file="" id="image" name="image" />
                                            @error('image')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-2 mt-4">
                                            @if($visi->image)
                                            <img src="{{ asset('storage/identities/' . $visi->image) }}" alt="{{$visi->title}}" class="admin-edit-image">
                                            @else
                                            <img src="{{ asset('storage/identities/no_image.jpg') }}" class="admin-edit-image">
                                            @endif
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
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection