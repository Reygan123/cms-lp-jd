@extends('layouts.app', ['title' => 'Categories'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-right">Edit</h4>
                    <form action="{{ route('admin.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="text-label" for="name">Category Name</label>
                                    <input class="form-control" type="text" name="name" value="{{ old('name', $category->name) }}" placeholder="Nama Kategori">
                                    @error('name')
                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                        <div class="px-4 py-2">
                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                        </div>
                                    </div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mt-4">
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
                                    <div class="col-sm-6">
                                    <div class="mb-2 mt-4">
                                            @if($category->image)
                                            <img src="{{ asset('storage/categories/' . $category->image) }}" alt="{{$category->title}}" class="admin-edit-image">
                                            @else
                                            <img src="{{ asset('storage/identities/no_image.jpg') }}" class="admin-edit-image">
                                            @endif
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="flex justify-start mt-4">
                            <button type="submit" class="px-4 py-2 bg-gray-600 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700">UPDATE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection