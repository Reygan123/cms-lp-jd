@extends('layouts.app', ['title' => 'Identitas'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-right">Edit</h4>
                        <form action="{{ route('admin.identity.update', $identity->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label class="text-label" for="name">Organization Name</label>
                                                <input class="form-control" type="text" name="name"
                                                    value="{{ old('name', $identity->name) }}" placeholder="Nama Sekolah">
                                                @error('name')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="text-label" for="year">Year</label>
                                                <input class="form-control" type="text" name="year"
                                                    value="{{ old('year', $identity->year) }}" placeholder="Tahun Ajaran">
                                                @error('year')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-label" for="description">Meta Description</label>
                                        <textarea id="editor2" name="description">{{ old('description', $identity->description) }}</textarea>
                                        @error('description')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="text-label" for="address">Address</label>
                                        <textarea id="editor1" name="address">{{ old('address', $identity->address) }}</textarea>
                                        @error('address')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="text-gray-700 py-2" for="gmap">Link Google Map</label>
                                        <input class="form-control" type="text" name="gmap"
                                            value="{{ old('gmap', $identity->gmap) }}" placeholder="Link Google Map">
                                        @error('gmap')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-label" for="phone">Mobile Contact</label>
                                                <input class="form-control" type="text" name="phone"
                                                    value="{{ old('phone', $identity->phone) }}"
                                                    placeholder="Nomor Telepon">
                                                @error('phone')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-label" for="email">Email</label>
                                                <input class="form-control" type="email" name="email"
                                                    value="{{ old('email', $identity->email) }}"
                                                    placeholder="Alamat Email">
                                                @error('email')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-label" for="fb">Id Facebook</label>
                                                <input class="form-control" type="text" name="fb"
                                                    value="{{ old('fb', $identity->fb) }}"
                                                    placeholder="https://www.facebook.com/id_facebook">
                                                @error('fb')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-label" for="ig">Id Instagram</label>
                                                <input class="form-control" type="text" name="ig"
                                                    value="{{ old('ig', $identity->ig) }}"
                                                    placeholder="https://www.instagram.com/id_instagram">
                                                @error('ig')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-label" for="tt">Id Tiktok</label>
                                                <input class="form-control" type="text" name="tt"
                                                    value="{{ old('tt', $identity->tt) }}"
                                                    placeholder="https://www.tiktok.com/id_tiktok">
                                                @error('tt')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-label" for="yt">Id Youtube</label>
                                                <input class="form-control" type="text" name="yt"
                                                    value="{{ old('yt', $identity->yt) }}"
                                                    placeholder="https://www.youtube.com/@id_youtube">
                                                @error('yt')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-label" for="time_service">Time Service</label>
                                                <input class="form-control" type="text" name="time_service"
                                                    value="{{ old('time_service', $identity->time_service) }}"
                                                    placeholder="Waktu Layanan">
                                                @error('time_service')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-label" for="day_service">Day Service</label>
                                                <input class="form-control" type="text" name="day_service"
                                                    value="{{ old('day_service', $identity->day_service) }}"
                                                    placeholder="Hari Layanan">
                                                @error('day_service')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-label" for="link">Donation Link</label>
                                            <input class="form-control" type="text" name="link" value="{{ old('link', $identity->link) }}" placeholder="Link untuk donasi">
                                            @error('link')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-2 mt-4">
                                                @if ($identity->logo && file_exists(public_path('storage/identities/' . $identity->logo)))
                                                    <img src="{{ asset('storage/identities/' . $identity->logo) }}"
                                                        alt="{{ $identity->title }}" class="admin-edit-logo">
                                                @else
                                                    <img src="{{ asset('storage/identities/no_image.jpg') }}"
                                                        class="admin-edit-image">
                                                @endif

                                            </div>
                                            <div class="mb-2 mt-4">
                                                <label class="text-gray-700" for="logo">Logo (Max Size: 300kb)</label>
                                                <input type="file" class="dropify" data-default-file=""
                                                    id="logo" name="logo" />
                                                @error('logo')
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
                                                @if ($identity->favicon && file_exists(public_path('storage/identities/' . $identity->favicon)))
                                                    <img src="{{ asset('storage/identities/' . $identity->favicon) }}"
                                                        alt="{{ $identity->title }}" class="admin-edit-favicon">
                                                @else
                                                    <img src="{{ asset('storage/identities/no_image.jpg') }}"
                                                        class="admin-edit-image">
                                                @endif
                                            </div>
                                            <div class="mb-2 mt-4">
                                                <label class="text-gray-700" for="favicon">Favicon (Max Size:
                                                    100kb)</label>
                                                <input type="file" class="dropify" data-default-file=""
                                                    id="favicon" name="favicon" />
                                                @error('favicon')
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
