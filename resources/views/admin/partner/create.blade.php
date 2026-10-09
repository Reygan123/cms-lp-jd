@extends('layouts.app', ['title' => 'Partners'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-right">Create</h5>
                        <form action="{{ route('admin.partner.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group mb-4">
                                                <label class="text-label" for="name">Partner's Name</label>
                                                <input class="form-control" type="text" name="name"
                                                    value="{{ old('name') }}" placeholder="Name">
                                                @error('name')
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
                                                        <label class="text-label" for="category">Kategori Partner <span class="text-danger">*</span></label>
                                                        <select class="form-control" name="category" id="category" required>
                                                            @foreach ($categories as $catKey => $catLabel)
                                                                <option value="{{ $catKey }}" {{ old('category', 'sekolah') == $catKey ? 'selected' : '' }}>
                                                                    {{ $catLabel }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('category')
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
                                                        <label class="text-label" for="level" id="levelLabel">Jenjang / Level</label>
                                                        <div id="schoolLevelWrapper">
                                                            <select class="form-control" id="schoolLevelSelect">
                                                                <option value="">-- Pilih Jenjang Sekolah --</option>
                                                                @foreach ($schoolLevels as $lvlKey => $lvlLabel)
                                                                    <option value="{{ $lvlKey }}" {{ old('level') == $lvlKey ? 'selected' : '' }}>
                                                                        {{ $lvlLabel }}
                                                                    </option>
                                                                @endforeach
                                                                <option value="__CUSTOM__" {{ (!empty(old('level')) && !array_key_exists(old('level'), $schoolLevels)) ? 'selected' : '' }}>Lainnya / Input Manual</option>
                                                            </select>
                                                        </div>
                                                        <input class="form-control mt-2" type="text" name="level" id="level"
                                                            value="{{ old('level') }}" placeholder="Contoh: SMK, SMA, atau level lainnya">
                                                        <small class="text-muted" id="levelHelp">Pilih jenjang sekolah atau ketik manual.</small>
                                                        @error('level')
                                                             <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                                 <div class="px-4 py-2">
                                                                     <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                                 </div>
                                                             </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label class="text-label" for="web">Partner's Web Address</label>
                                                <input class="form-control" type="text" name="web"
                                                    value="{{ old('web') }}" placeholder="Web">
                                                @error('web')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label class="text-label" for="description">Partner Description</label>
                                                <textarea id="editor1" class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label class="text-label" for="program_desc">Partenership Details</label>
                                                <textarea id="editor2" class="form-control" name="program_desc" rows="3">{{ old('program_desc') }}</textarea>
                                                @error('program_desc')
                                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                                        <div class="px-4 py-2">
                                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                                        </div>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
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
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-start mt-4">
                                <button type="submit" class="btn btn-primary">CREATE</button>
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

        // Dynamic Category & Level Handler
        $(document).ready(function() {
            function updateLevelUI() {
                var category = $('#category').val();
                var $schoolWrapper = $('#schoolLevelWrapper');
                var $schoolSelect = $('#schoolLevelSelect');
                var $levelInput = $('#level');
                var $levelLabel = $('#levelLabel');
                var $levelHelp = $('#levelHelp');

                if (category === 'sekolah') {
                    $schoolWrapper.show();
                    $levelLabel.html('Jenjang Sekolah <span class="text-danger">*</span>');
                    $levelHelp.text('Pilih jenjang sekolah atau pilih Lainnya untuk mengisi manual.');
                    
                    // Sync select if input matches an existing option
                    var currentVal = $levelInput.val();
                    if (currentVal && $schoolSelect.find('option[value="' + currentVal + '"]').length > 0) {
                        $schoolSelect.val(currentVal);
                    }
                } else {
                    $schoolWrapper.hide();
                    $levelLabel.text('Tingkatan / Level (Opsional)');
                    $levelHelp.text('Opsional. Contoh: Universitas, Institut, BUMN, Swasta, Startup, dll.');
                }
            }

            $('#category').on('change', function() {
                updateLevelUI();
            });

            $('#schoolLevelSelect').on('change', function() {
                var selectedVal = $(this).val();
                if (selectedVal && selectedVal !== '__CUSTOM__') {
                    $('#level').val(selectedVal);
                } else if (selectedVal === '__CUSTOM__') {
                    $('#level').val('').focus();
                }
            });

            // Initial run
            updateLevelUI();
        });
    </script>
@endsection
