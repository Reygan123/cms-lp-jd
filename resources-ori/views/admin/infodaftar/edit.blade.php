@extends('layouts.app', ['title' => 'Addmission Info'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-right">Edit</h5>
                        <form action="{{ route('admin.infodaftar.update', $infodaftar->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-label" for="title">Title</label>
                                                <input class="form-control" type="text" name="title"
                                                    value="{{ old('title', $infodaftar->title) }}" placeholder="">
                                                @error('title')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mt-4">
                                                <label class="text-label" for="subtitle">Sub Title</label>
                                                <input class="form-control" type="text" name="subtitle"
                                                    value="{{ old('subtitle', $infodaftar->subtitle) }}" placeholder="">
                                                @error('subtitle')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mt-4">
                                                <label class="text-label" for="description">Addmission Description</label>
                                                <textarea id="editor" name="description" rows="15">{{ old('description', $infodaftar->description) }}</textarea>
                                                @error('description')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <hr>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mt-4">
                                                <label class="text-label" for="text_investasi">Addmission Info 1</label>
                                                <textarea id="editor1" name="text_investasi" rows="15">{{ old('text_investasi', $infodaftar->text_investasi) }}</textarea>
                                                @error('text_investasi')
                                                    <div
                                                        class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mt-4">
                                                <label class="text-label" for="text_daftar">Addmission Info 2</label>
                                                <textarea id="editor2" name="text_daftar" rows="15">{{ old('text_daftar', $infodaftar->text_daftar) }}</textarea>
                                                @error('text_daftar')
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
                                    <div class="flex justify-start mt-4">
                                        <button type="submit" class="btn btn-primary">UPDATE</button>
                                    </div>
                                </div>
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
        ClassicEditor
            .create(document.querySelector('#editor2'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
