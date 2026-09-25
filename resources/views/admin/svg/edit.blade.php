@extends('layouts.app', ['title' => 'Data & Value'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-right">Edit</h4>
                    <form action="{{ route('admin.svg.update', $svg->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <label class="text-label mb-4" for="name">
                                    <h6>Data</h6>
                                </label>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group mb-4">
                                            <label class="text-label" for="title1">Title Data 1</label>
                                            <input class="form-control" type="text" name="title1" value="{{ old('title1', $svg->title1) }}">
                                            @error('title1')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label" for="data1">Data 1</label>
                                            <input class="form-control" type="text" name="data1" value="{{ old('data1', $svg->data1) }}">
                                            @error('data1')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group mb-4">
                                            <label class="text-label" for="title2">Title Data 2</label>
                                            <input class="form-control" type="text" name="title2" value="{{ old('title2', $svg->title2) }}">
                                            @error('title2')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label" for="data2">Data 2</label>
                                            <input class="form-control" type="text" name="data2" value="{{ old('data2', $svg->data2) }}">
                                            @error('data2')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group mb-4">
                                            <label class="text-label" for="title3">Title Data 3</label>
                                            <input class="form-control" type="text" name="title3" value="{{ old('title3', $svg->title3) }}">
                                            @error('title3')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label" for="data3">Data 3</label>
                                            <input class="form-control" type="text" name="data3" value="{{ old('data3', $svg->data3) }}">
                                            @error('data3')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group mb-4">
                                            <label class="text-label" for="title4">Title Data 4</label>
                                            <input class="form-control" type="text" name="title4" value="{{ old('title4', $svg->title4) }}">
                                            @error('title4')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label" for="data4">Data 4</label>
                                            <input class="form-control" type="text" name="data4" value="{{ old('data4', $svg->data4) }}">
                                            @error('data4')
                                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                </div>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <label class="text-label mb-4 mt-4" for="name">
                                    <h6>Values</h6>
                                </label>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="text-label" for="value1">Value 1</label>
                                            <input class="form-control" type="text" name="value1" value="{{ old('value1', $svg->value1) }}">
                                            @error('value1')
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
                                            <label class="text-label" for="value2">Value 2</label>
                                            <input class="form-control" type="text" name="value2" value="{{ old('value2', $svg->value2) }}">
                                            @error('value2')
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
                                            <label class="text-label" for="value3">Value 3</label>
                                            <input class="form-control" type="text" name="value3" value="{{ old('value3', $svg->value3) }}">
                                            @error('value3')
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
                                            <label class="text-label" for="value4">Value 4</label>
                                            <input class="form-control" type="text" name="value4" value="{{ old('value4', $svg->value4) }}">
                                            @error('value4')
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
                                            <label class="text-label" for="value5">Value 5</label>
                                            <input class="form-control" type="text" name="value5" value="{{ old('value5', $svg->value5) }}">
                                            @error('value5')
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
                                            <label class="text-label" for="value6">Value 6</label>
                                            <input class="form-control" type="text" name="value6" value="{{ old('value6', $svg->value6) }}">
                                            @error('value6')
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

@endsection