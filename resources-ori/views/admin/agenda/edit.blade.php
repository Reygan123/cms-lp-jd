@extends('layouts.app', ['title' => 'Agenda'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-right">Edit</h5>
                        <form action="{{ route('admin.agenda.update', $agenda->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-4">
                                        <label class="text-label" for="title">Title</label>
                                        <input class="form-control" type="text" name="title"
                                            value="{{ old('title', $agenda->title) }}" placeholder="Agenda's Title">
                                        @error('title')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="text-label" for="start_date">Start Date</label>
                                                        <input class="form-control" placeholder="2017-06-04" type="date"
                                                            name="start_date"
                                                            value="{{ old('start_date', $agenda->start_date) }}">
                                                        @error('start_date')
                                                            <div
                                                                class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                                <div class="px-4 py-2">
                                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                                </div>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="text-label" for="start_time">Start Time</label>
                                                        <input class="form-control" placeholder="2017-06-04" type="time"
                                                            name="start_time"
                                                            value="{{ old('start_time', $agenda->start_time) }}">
                                                        @error('start_time')
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
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="text-label" for="end_date">Enda Date</label>
                                                        <input class="form-control" placeholder="2017-06-04" type="date"
                                                            name="end_date"
                                                            value="{{ old('end_date', $agenda->end_date) }}">
                                                        @error('end_date')
                                                            <div
                                                                class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                                <div class="px-4 py-2">
                                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                                </div>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="text-label" for="end_time">End Time</label>
                                                        <input class="form-control" placeholder="2017-06-04" type="time"
                                                            name="end_time"
                                                            value="{{ old('end_time', $agenda->end_time) }}">
                                                        @error('end_time')
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
                                    <div class="form-group mb-4 ">
                                        <label class="text-label" for="content">Description</label>
                                        <textarea id="editor2" name="content">{{ old('content', $agenda->content) }}</textarea>
                                        @error('content')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-4">
                                                <label class="text-label" for="organizer">Event Organizer</label>
                                                <input class="form-control" type="text" name="organizer"
                                                    value="{{ old('organizer', $agenda->organizer) }}"
                                                    placeholder="Event Organizer">
                                                @error('organizer')
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
                                                <label class="text-label" for="location">Location</label>
                                                <input class="form-control" type="text" name="location"
                                                    value="{{ old('location', $agenda->location) }}"
                                                    placeholder="Event's Location">
                                                @error('location')
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
                                                <label class="text-label" for="yt_link">Link Youtube</label>
                                                <input class="form-control" type="text" maxlength="11" name="yt_link"
                                                    value="{{ old('yt_link', $agenda->yt_link) }}"
                                                    placeholder="Youtube video link">
                                                @error('yt_link')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-4">
                                                <label class="text-label" for="register_link">Register Link</label>
                                                <input class="form-control" type="text" name="register_link"
                                                    value="{{ old('register_link', $agenda->register_link) }}"
                                                    placeholder="link for registration">
                                                @error('register_link')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-4">
                                                <label class="text-label" for="contact">Contact</label>
                                                <input class="form-control" type="number" maxlength="12" name="contact"
                                                    value="{{ old('contact', $agenda->contact) }}"
                                                    placeholder="Event contact no">
                                                @error('contact')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mt-4">
                                                <label class="text-gray-700" for="image">Upload Image (Max Size:
                                                    750kb)</label>
                                                <input type="file" class="dropify" data-default-file=""
                                                    id="image" name="image" />
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
                                            <div class="form-group mt-4">
                                                @if ($agenda->image)
                                                    <img src="{{ asset('storage/agendas/' . $agenda->image) }}" class="admin-edit-image">
                                                @else
                                                    <img src="{{ asset('storage/identities/no_image.jpg') }}"
                                                        class="admin-edit-image">
                                                @endif
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
    </script>
@endsection
