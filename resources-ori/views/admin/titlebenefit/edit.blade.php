@extends('layouts.app', ['title' => 'Title Benefit'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.titlebenefit.update', $titlebenefit->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="text-label" for="title">Title</label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title', $titlebenefit->title) }}">
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

                                    <textarea class="form-control" name="description" rows="3">{{ old('description', $titlebenefit->description) }}</textarea>
                                    @error('description')
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
                                            @if ($titlebenefit->image && file_exists(public_path('storage/benefits/'.$titlebenefit->image)))
                                            <div class="container-image">
                                                <img src="{{asset('storage/benefits/'.$titlebenefit->image)}}" class="admin-edit-image">
                                                <div class="top-right-object">
                                                    <a href="{{ route('admin.titlebenefit.deleteImage', ['titlebenefit' => $titlebenefit->id, 'image' => 'image']) }}" class="top-right-close">
                                                        <i class="fa-sharp fa-light fa-circle-xmark"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            @else
                                            <img src="{{ asset('storage/identities/no_image.jpg') }}" class="admin-edit-image">
                                            @endif
                                        </div>

                                    </div>
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
                                </div>
                            </div>
                        </div>



                        <div class="flex justify-start mt-4">
                            <button type="submit" class="btn btn-primary btn-rounded">SIMPAN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection