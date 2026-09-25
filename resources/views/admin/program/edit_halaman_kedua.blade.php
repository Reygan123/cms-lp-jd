@extends('layouts.app', ['title' => 'Program'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="flex" style="justify-content: space-between;">
                            <h5>Deskripsi Program</h5>
                            <h5 class="">Add</h5>
                        </div>
                        <form action="{{ route('admin.program.edit.halaman-kedua', $program->id) }}" method="POST"
                            enctype="multipart/form-data" id="step-form-horizontal" class="step-form-horizontal">
                            @csrf
                            @method('put')
                            <section>
                                <div class="row">
                                    <div class="col-12">
                                        <div role="application" class="wizard clearfix" id="steps-uid-0">
                                            <div class="steps clearfix">
                                                <ul role="tablist">
                                                    <li role="tab" class="disabled" aria-disabled="true"><a
                                                            id="steps-uid-0-t-0" href="#steps-uid-0-h-0"
                                                            aria-controls="steps-uid-0-p-0"><span
                                                                class="current-info audible">current step: </span><span
                                                                class="number">1.</span> Program Description</a></li>
                                                    <li role="tab" class="first current" aria-disabled="false"
                                                        aria-selected="true"><a id="steps-uid-0-t-1" href="#steps-uid-0-h-1"
                                                            aria-controls="steps-uid-0-p-1"><span class="number">2.</span>
                                                            Program Description</a></li>
                                                    <li role="tab" class="disabled" aria-disabled="true"><a
                                                            id="steps-uid-0-t-2" href="#steps-uid-0-h-2"
                                                            aria-controls="steps-uid-0-p-2"><span class="number">3.</span>
                                                            Program Description</a></li>
                                                </ul>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-9">
                                                    <div class="form-group mb-4">
                                                        <label class="text-label">Supporting By</label>
                                                        <div class="row mt-2">
                                                            @foreach ($dukungans as $dukungan)
                                                            <div class="col-sm-6">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="dukungan_ids[]"
                                                                               value="{{ $dukungan->id }}"
                                                                               {{ in_array($dukungan->id, old('dukungan_ids', $program->dukungans->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                                        {{ $dukungan->title }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                        @error('dukungan_ids')
                                                        <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                            <div class="px-4 py-2">
                                                                <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                            </div>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    
                                                    <div class="form-group mb-4">
                                                        <label class="text-label" for="title2">Title Section 2</label>
                                                        <input class="form-control" type="text" name="title2"
                                                            value="{{ old('title2', $program->title2) }}"
                                                            placeholder="Title Section 2">
                                                        @error('title2')
                                                            <div
                                                                class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                                <div class="px-4 py-2">
                                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                                </div>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label class="text-label" for="description2">Description Section
                                                            2</label>
                                                        <textarea id="editor1" name="description2">{{ old('description2', $program->description2) }}</textarea>
                                                        @error('description2')
                                                            <div
                                                                class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                                <div class="px-4 py-2">
                                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                                </div>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="text-label" for="image2">Image 2</label>
                                                    <div class="form-group">
                                                        @if ($program->image2 && file_exists(public_path('storage/programs/' . $program->image2)))
                                                            <img src="{{ asset('storage/programs/' . $program->image2) }}"
                                                                alt="{{ $program->name }}" class="admin-edit-image">
                                                        @else
                                                            <img src="{{ asset('storage/identities/no_image.jpg') }}"
                                                                class="admin-edit-image">
                                                        @endif
                                                    </div>
                                                    <div class="mb-2 mt-4">
                                                        <label class="text-gray-700" for="image2">Upload Image 2 (Max
                                                            Size: 750kb)</label>
                                                        <input type="file" class="dropify" data-default-file=""
                                                            id="image2" name="image2" />
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
                                            <div class="row mt-4">
                                                <div class="col-md-9">
                                                    <div class="form-group mb-4">
                                                        <label class="text-label" for="title3">Title Section 3</label>
                                                        <input class="form-control" type="text" name="title3"
                                                            value="{{ old('title3', $program->title3) }}"
                                                            placeholder="Title Section 3">
                                                        @error('title3')
                                                            <div
                                                                class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                                <div class="px-4 py-2">
                                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                                </div>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label class="text-label" for="description3">Description Section
                                                            3</label>
                                                        <textarea id="editor2" name="description3">{{ old('description3', $program->description3) }}</textarea>
                                                        @error('description3')
                                                            <div
                                                                class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                                <div class="px-4 py-2">
                                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                                </div>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="text-label" for="image3">Image 3</label>
                                                    <div class="form-group">
                                                        @if ($program->image3 && file_exists(public_path('storage/programs/' . $program->image3)))
                                                            <img src="{{ asset('storage/programs/' . $program->image3) }}"
                                                                alt="{{ $program->name }}" class="admin-edit-image">
                                                        @else
                                                            <img src="{{ asset('storage/identities/no_image.jpg') }}"
                                                                class="admin-edit-image">
                                                        @endif
                                                    </div>
                                                    <div class="mb-2 mt-4">
                                                        <label class="text-gray-700" for="image3">Upload Image 3 (Max
                                                            Size: 750kb)</label>
                                                        <input type="file" class="dropify" data-default-file=""
                                                            id="image3" name="image3" />
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

                                        </div>
                                    </div>
                                </div>
                            </section>


                            <div class="flex justify-between mt-4">
                                <a href="{{ route('admin.program.edit.halaman-pertama', $program->id) }}"
                                    class="btn btn-light btn-rounded">Previous</a>
                                <button type="submit" class="btn btn-primary btn-rounded">Next</button>
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
    </script>
@endsection
