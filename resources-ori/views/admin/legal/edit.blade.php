@extends('layouts.app', ['title' => 'Legal Certificates'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-right">Edit</h4>
                    <form action="{{ route('admin.legal.update', $legal->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="text-label" for="title">Legal's Title</label>
                                            <input class="form-control" type="text" name="title" value="{{ old('title', $legal->title) }}" placeholder="Judul Legal">
                                            @error('title')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-4">
                                            <label class="text-label" for="name">Description</label>
                                            <textarea id="editor1" name="description" rows="15">{{ old('description', $legal->description) }}</textarea>
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
                                        <div class="form-group mb-4">
                                            @if($legal->image)
                                            <img src="{{ asset('storage/identities/' . $legal->image) }}" alt="{{$legal->title}}" class="admin-edit-image">
                                            @else
                                            <img src="{{ asset('storage/identities/no_image.jpg') }}" class="admin-edit-image">
                                            @endif
                                        </div>
                                        <div class="mb-4">
                                            <label class="text-gray-700" for="image">Upload Image (Max Size: 750kb)</label>
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