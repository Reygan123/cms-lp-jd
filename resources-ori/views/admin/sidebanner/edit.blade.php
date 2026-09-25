@extends('layouts.app', ['title' => 'Side Banner'])

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-right">Edit</h4>
                    <form action="{{ route('admin.sidebanner.update', $sidebanner->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{asset('storage/identities/'.$sidebanner->image)}}" class="thumbnails">
                            </div>
                            <div class="col-md-6">
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
                                <div class="form-group">
                                    <label class="text-label" for="link">Link Banner</label>
                                    <input class="form-control" type="text" name="link" value="{{ old('link', $sidebanner->link) }}" placeholder="Link Banner">
                                    @error('link')
                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                        <div class="px-4 py-2">
                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                        </div>
                                    </div>
                                    @enderror
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
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            });

    </script>
@endsection