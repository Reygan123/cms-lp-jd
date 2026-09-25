@extends('layouts.app', ['title' => 'Program'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="flex" style="justify-content: space-between;">
                            <h5>Deskripsi Program</h5>
                            <h5 class="">Edit</h5>
                        </div>
                        <form action="{{ route('admin.program.edit.halaman-pertama', $program->id) }}" method="POST"
                            enctype="multipart/form-data" id="step-form-horizontal" class="step-form-horizontal">
                            @csrf
                            @method('put')
                            <section>
                                <div class="row">
                                    <div class="col-12">
                                        <div role="application" class="wizard clearfix" id="steps-uid-0">
                                            <div class="steps clearfix">
                                                <ul role="tablist">
                                                    <li role="tab" class="first current" aria-disabled="false"
                                                        aria-selected="true"><a id="steps-uid-0-t-0" href="#steps-uid-0-h-0"
                                                            aria-controls="steps-uid-0-p-0"><span
                                                                class="current-info audible">current step: </span><span
                                                                class="number">1.</span> Program Description</a></li>
                                                    <li role="tab" class="disabled" aria-disabled="tru"><a
                                                            id="steps-uid-0-t-1" href="#steps-uid-0-h-1"
                                                            aria-controls="steps-uid-0-p-1"><span class="number">2.</span>
                                                            Program Description</a></li>
                                                    <li role="tab" class="disabled" aria-disabled="true"><a
                                                            id="steps-uid-0-t-2" href="#steps-uid-0-h-2"
                                                            aria-controls="steps-uid-0-p-2"><span class="number">3.</span>
                                                            Program Description</a></li>
                                                </ul>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="form-group mb-4">
                                                        <label class="text-label" for="name">Name</label>
                                                        <input class="form-control" type="text" name="name"
                                                            value="{{ old('name', $program->name) }}"
                                                            placeholder="Name of Program">
                                                        @error('name')
                                                            <div
                                                                class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                                <div class="px-4 py-2">
                                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                                </div>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <!-- Tambahkan Checkbox untuk Memilih Fasilitas -->
                                                    <div class="form-group mb-4">
                                                        <label class="text-label">Assessment</label>
                                                        <div class="row">
                                                            @foreach ($facilities as $facility)
                                                            <div class="col-sm-6">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="facility_ids[]"
                                                                            value="{{ $facility->id }}"
                                                                            {{ in_array($facility->id, old('facility_ids', $program->facilities->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                                        {{ $facility->title }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        </div>
                                                        @error('facility_ids')
                                                            <div
                                                                class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                                <div class="px-4 py-2">
                                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                                </div>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <!-- <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group mb-4">
                                                                <label class="text-label" for="age">Age Group</label>
                                                                <input class="form-control" type="text" name="age"
                                                                    value="{{ old('age', $program->age) }}"
                                                                    placeholder="Student age range">
                                                                @error('age')
                                                                    <div
                                                                        class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                                        <div class="px-4 py-2">
                                                                            <p class="text-gray-600 text-sm">{{ $message }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group mb-4">
                                                                <label class="text-label" for="weekly">Weekly
                                                                    Meets</label>
                                                                <input class="form-control" type="text" name="weekly"
                                                                    value="{{ old('weekly', $program->weekly) }}"
                                                                    placeholder="Number of weekly meets">
                                                                @error('weekly')
                                                                    <div
                                                                        class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                                        <div class="px-4 py-2">
                                                                            <p class="text-gray-600 text-sm">
                                                                                {{ $message }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group mb-4">
                                                                <label class="text-label" for="periode">Meeting
                                                                    Duration</label>
                                                                <input class="form-control" type="text" name="periode"
                                                                    value="{{ old('periode', $program->periode) }}"
                                                                    placeholder="Meeting duration in a day ">
                                                                @error('periode')
                                                                    <div
                                                                        class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                                        <div class="px-4 py-2">
                                                                            <p class="text-gray-600 text-sm">
                                                                                {{ $message }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group mb-4">
                                                                <label class="text-label" for="class_size">Class
                                                                    Size</label>
                                                                <input class="form-control" type="text"
                                                                    name="class_size"
                                                                    value="{{ old('class_size', $program->class_size) }}"
                                                                    placeholder="Number of student in a class">
                                                                @error('class_size')
                                                                    <div
                                                                        class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                                        <div class="px-4 py-2">
                                                                            <p class="text-gray-600 text-sm">
                                                                                {{ $message }}</p>
                                                                        </div>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <div class="form-group mb-4">
                                                        <label class="text-label" for="title1">Title Section 1</label>
                                                        <input class="form-control" type="text" name="title1"
                                                            value="{{ old('title1', $program->title1) }}"
                                                            placeholder="Title Section 1">
                                                        @error('title1')
                                                            <div
                                                                class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                                <div class="px-4 py-2">
                                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                                </div>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label class="text-label" for="description1">Description Section
                                                            1</label>
                                                        <textarea id="editor1" name="description1">{{ old('description1', $program->description1) }}</textarea>
                                                        @error('description1')
                                                            <div
                                                                class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                                <div class="px-4 py-2">
                                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                                </div>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="text-label" for="name">Program's Leader</label>
                                                        <select class="form-control" name="ourteam_id">

                                                            @foreach ($ourteams as $ourteam)
                                                                <option class="py-1" value="{{ $ourteam->id }}"
                                                                    @if ($program->ourteam_id == $ourteam->id) selected @endif>
                                                                    {{ $ourteam->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('ourteam_id')
                                                            <div
                                                                class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                                <div class="px-4 py-2">
                                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                                </div>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        @if ($program->image1 && file_exists(public_path('storage/programs/' . $program->image1)))
                                                            <img src="{{ asset('storage/programs/' . $program->image1) }}"
                                                                alt="{{ $program->name }}" class="admin-edit-image">
                                                        @else
                                                            <img src="{{ asset('storage/identities/no_image.jpg') }}"
                                                                class="admin-edit-image">
                                                        @endif
                                                    </div>
                                                    <div class="mb-4 mt-4">
                                                        <label class="text-gray-700" for="image1">Upload Image (Max
                                                            Size: 750kb)</label>
                                                        <input type="file" class="dropify" data-default-file=""
                                                            id="image1" name="image1" />
                                                        @error('image1')
                                                            <div
                                                                class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                                <div class="px-4 py-2">
                                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                                </div>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        @if ($program->id_yt !== null)
                                                            <iframe width="100%" height="250"
                                                                src="https://www.youtube.com/embed/{{ $program->id_yt }}?autoplay=1&mute=1">
                                                            </iframe>
                                                        @endif

                                                        <label class="text-label" for="id_yt">ID Youtube</label>
                                                        <input class="form-control" type="text" name="id_yt"
                                                            value="{{ old('id_yt', $program->id_yt) }}"
                                                            placeholder="ID Youtube">
                                                        @error('id_yt')
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

                            <div class="flex justify-end mt-4">
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
    </script>
@endsection
