@extends('layouts.app', ['title' => 'Achievement'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-right">Edit</h5>
                    <form action="{{ route('admin.prestasi.update', $prestasi->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group mb-4">
                                            <input type="checkbox" name="home" id="home" value="1"
                                                {{ old('home', $prestasi->home) ? 'checked' : '' }}>
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
                                                    <option class="py-1" value="{{ $program->id }}"
                                                        @if ($prestasi->program_id == $program->id) selected @endif>{{ $program->name }}
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
                                        <div class="form-group mb-4">
                                            <label class="text-label" for="title">Title</label>
                                            <input type="text" class="form-control" name="title" value="{{ old('title', $prestasi->title) }}">
                                            @error('title')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label" for="categoriprestasi_id">Program Name</label>
                                            <select class="form-control" name="categoriprestasi_id">
        
                                                @foreach ($categoriprestasis as $cp)
                                                    <option class="py-1" value="{{ $cp->id }}"
                                                        @if ($prestasi->categoriprestasi_id == $cp->id) selected @endif>{{ $cp->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('categoriprestasi_id')
                                                <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                    <div class="px-4 py-2">
                                                        <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                    </div>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-4">
                                            <label class="text-label" for="name">Winner's Name</label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name', $prestasi->name) }}">
                                            @error('name')
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
                                            @if($prestasi->image)
                                            <img src="{{ asset('storage/prestasis/' . $prestasi->image) }}" alt="{{$prestasi->title}}" class="admin-edit-image">
                                            @else
                                            <img src="{{ asset('storage/identities/no_image.jpg') }}" class="admin-edit-image">
                                            @endif
                                        </div>
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
                            <button type="submit" class="btn btn-primary">SIMPAN</button>
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
    ClassicEditor
        .create(document.querySelector('#editor2'))
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#editor3'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection