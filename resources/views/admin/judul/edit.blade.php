@extends('layouts.app', ['title' => 'Testimony Title'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-right">Edit</h5>
                    <form action="{{ route('admin.judul.update', $judul->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-4">
                                    <label class="text-label" for="title">Title</label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title', $judul->title) }}">
                                    @error('title')
                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden">
                                        <div class="px-4 py-2">
                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                        </div>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="text-label" for="heading">Sub Title</label>

                                    <textarea id="" class="form-control" name="description" rows="3">{{ old('description', $judul->description) }}</textarea>
                                    @error('description')
                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                        <div class="px-4 py-2">
                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                        </div>
                                    </div>
                                    @enderror
                                </div>
                                <div class="flex justify-start mt-4">
                                    <button type="submit" class="btn btn-primary">SIMPAN</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection