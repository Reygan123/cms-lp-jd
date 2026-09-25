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
                        <form action="{{ route('admin.program.edit.halaman-ketiga', $program->id) }}" method="POST"
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
                                                    <li role="tab" class="disabled" aria-disabled="true"><a
                                                            id="steps-uid-0-t-1" href="#steps-uid-0-h-1"
                                                            aria-controls="steps-uid-0-p-1"><span class="number">2.</span>
                                                            Program Description</a></li>
                                                    <li role="tab" class="third current" aria-disabled="false"
                                                        aria-selected="true"><a id="steps-uid-0-t-2" href="#steps-uid-0-h-2"
                                                            aria-controls="steps-uid-0-p-2"><span class="number">3.</span>
                                                            Program Description</a></li>
                                                </ul>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group mb-4">
                                                        <label class="text-label" for="title4">Title Section 4</label>
                                                        <input class="form-control" type="text" name="title4"
                                                            value="{{ old('title4', $program->title4) }}"
                                                            placeholder="Title Section 4">
                                                        @error('title4')
                                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                                <div class="px-4 py-2">
                                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                                </div>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label class="text-label" for="description4">Description Section 4</label>
                                                        <textarea id="editor1" name="description4">{{ old('description4', $program->description4) }}</textarea>
                                                        @error('description4')
                                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                                <div class="px-4 py-2">
                                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                                </div>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="text-label" for="image4">Image Section 4</label>
                                                    <div class="form-group">
                                                        @if ($program->image4 && file_exists(public_path('storage/programs/' . $program->image4)))
                                                        <img src="{{ asset('storage/programs/' . $program->image4) }}"
                                                            alt="{{ $program->name }}" class="admin-edit-image">
                                                    @else
                                                        <img src="{{ asset('storage/identities/no_image.jpg') }}"
                                                            class="admin-edit-image">
                                                    @endif
                                                    </div>
                                                    <div class="mb-2 mt-4">
                                                        <label class="text-gray-700" for="image4">Upload Image (Max
                                                            Size: 750kb)</label>
                                                        <input type="file" class="dropify" data-default-file=""
                                                            id="image4" name="image4" />
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
                                            {{-- <label class="text-label text-center" for="time_table">Time Table</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-4">
                                                        <textarea id="editor3" name="time_table">{{ old('time_table', $program->time_table) }}</textarea>
                                                        @error('time_table')
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
                                                    <div class="form-group mb-4">
                                                        <textarea id="editor4" name="time_table2">{{ old('time_table2', $program->time_table2) }}</textarea>
                                                        @error('time_table2')
                                                            <div
                                                                class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                                <div class="px-4 py-2">
                                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                                </div>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div> --}}
                                            <div class="form-group mb-4">
                                                <label class="text-label" for="content">CTA Description</label>
                                                <textarea id="editor2" name="content">{{ old('content', $program->content) }}</textarea>
                                                @error('content')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-4">
                                                <label class="text-label" for="cta">CTA Button Text</label>
                                                <input class="form-control" type="text" name="cta"
                                                    value="{{ old('cta', $program->cta) }}" placeholder="Call to Action">
                                                @error('cta')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-4">
                                                        <label class="text-label" for="link_program">Link CTA</label>
                                                        <input class="form-control" type="text" name="link_program"
                                                            value="{{ old('link_program', $program->link_program) }}"
                                                            placeholder="Link Call to Action">
                                                        @error('link_program')
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
                                                    <div class="form-group mb-4">
                                                        <label class="text-label" for="brosur">Link Brochure</label>
                                                        <input class="form-control" type="text" name="brosur"
                                                            value="{{ old('brosur', $program->brosur) }}"
                                                            placeholder="Link untuk brosur">
                                                        @error('brosur')
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
                                <a href="{{ route('admin.program.edit.halaman-kedua', $program->id) }}"
                                    class="btn btn-light btn-rounded">Previous</a>
                                <button type="submit" class="btn btn-primary btn-rounded">Save</button>
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
            ClassicEditor
            .create(document.querySelector('#editor4'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
