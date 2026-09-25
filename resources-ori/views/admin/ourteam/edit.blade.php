@extends('layouts.app', ['title' => 'Our Teams'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-right">Edit</h5>
                        <form action="{{ route('admin.ourteam.update', $ourteam->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-4">
                                        <label class="text-label" for="ot_id">Our Team's Category</label>
                                        <select class="form-control" name="ot_id" id="ot_id">
                                            <option class="py-1" value="">-- Select Category --</option>
                                            <option class="py-1" value="1" {{ $ourteam->ot_id == 1 ? 'selected' : '' }}>Dewan Pembina</option>
                                            <option class="py-1" value="2" {{ $ourteam->ot_id == 2 ? 'selected' : '' }}>Dewan Direksi</option>
                                            <option class="py-1" value="3" {{ $ourteam->ot_id == 3 ? 'selected' : '' }}>Psychologist </option>
                                            <option class="py-1" value="4" {{ $ourteam->ot_id == 4 ? 'selected' : '' }}>Counselor</option>
                                            <option class="py-1" value="5" {{ $ourteam->ot_id == 5 ? 'selected' : '' }}>Peer Counselor</option>
                                            <option class="py-1" value="6" {{ $ourteam->ot_id == 6 ? 'selected' : '' }}>Dewan Pakar</option>
                                        </select>
                                        @error('ot_id')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-4">
                                        <label class="text-label" for="name">Name</label>
                                        <input class="form-control" type="text" name="name"
                                            value="{{ old('name', $ourteam->name) }}" placeholder="Name">
                                        @error('name')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-4">
                                        <label class="text-label" for="title">Title</label>
                                        <input class="form-control" type="text" name="title"
                                            value="{{ old('title', $ourteam->title) }}" placeholder="Title">
                                        @error('title')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-4">
                                        <label class="text-label" for="email">Email</label>
                                        <input class="form-control" type="email" name="email"
                                            value="{{ old('email', $ourteam->email) }}"
                                            placeholder="Ext. someone@domain.com ">
                                        @error('email')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-4">
                                                <label class="text-label" for="phone">Phone Number</label>
                                                <input class="form-control" type="text" name="phone"
                                                    value="{{ old('phone', $ourteam->phone) }}"
                                                    placeholder="Ext. 0811-1111-1111 ">
                                                @error('phone')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mb-4">
                                                <label class="text-label" for="fb">Facebook ID</label>
                                                <input class="form-control" type="text" name="fb"
                                                    value="{{ old('fb', $ourteam->fb) }}" placeholder="someone">
                                                @error('fb')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mb-4">
                                                <label class="text-label" for="ig">Instagram ID</label>
                                                <input class="form-control" type="text" name="ig"
                                                    value="{{ old('ig', $ourteam->if) }}" placeholder="someone">
                                                @error('ig')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mb-4">
                                                <label class="text-label" for="tt">Tiktok ID</label>
                                                <input class="form-control" type="text" name="tt"
                                                    value="{{ old('tt', $ourteam->tt) }}" placeholder="@someone">
                                                @error('tt')
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
                                            <div class="mb-2 mt-4">
                                                <label class="text-gray-700" for="image">Gambar (Max Size: 750kb)</label>
                                                <input type="file" class="dropify" data-default-file="" id="image"
                                                    name="image" />
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
                                                @if ($ourteam->image)
                                                    <img src="{{ asset('storage/ourteams/' . $ourteam->image) }}"
                                                        alt="{{ $ourteam->title }}" class="admin-edit-image">
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
    </script>
@endsection
