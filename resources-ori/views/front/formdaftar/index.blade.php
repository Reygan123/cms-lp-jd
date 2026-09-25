@extends('layouts.frontapp', ['title' => 'Pendaftaran'])

@section('content')
@foreach($header as $item)
<section class="header-page" style="background-image:url({{asset('storage/headers/'.$item->image)}});">
    <div class="container">
        <h1 class="center-text fw-600 lt-2 mb-10">{{$item->title}}</h1>
    </div>
</section>
<section class="mt-50 mb-100">
    <div class="container">
        <h2 class="text-center uppercase mt-50 mb-100">{{$item->title}}</h2>
@endforeach
    <div class="container mx-auto px-6 py-8">
            <form action="{{ route('front.formdaftar.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mt-4">
                        <label class="text-gray-700" for="image">FOTO SISWA (3x4)</label>
                        <input class="form-input w-full mt-2 rounded-md bg-gray-200 focus:bg-white p-3" type="file" name="image">
                        @error('image')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </div>
                    <di class="col-md-6 mt-4">
                        <label class="text-gray-700" for="name">NAMA LENGKAP CALON SISWA</label>
                        <input class="form-input w-full mt-2 rounded-md bg-gray-200 focus:bg-white" type="text" name="name" value="{{ old('name') }}" placeholder="Full Name">
                        @error('name')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </di>
                    <div class="col-sm-6 mt-5">
                        <div>
                            <label class="text-gray-700" for="image">Kelas & Program</label>
                            <select class="w-full border bg-gray-200 focus:bg-white rounded px-3 py-2 outline-none" aria-label=".form-select-sm example" name="kelas">
                                <option value="MIPA Unggulan Tahfidz Al Quran">MIPA Unggulan Tahfidz Al Quran</option>
                                <option value="IPS Unggulan Tahfidz Al Quran">IPS Unggulan Tahfidz Al Quran</option>
                                <option value="MIPA Reguler">MIPA Reguler</option>
                                <option value="IPS Reguler">IPS Reguler</option>
                            </select>
                            @error('kelas')
                                <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                    <div class="px-4 py-2">
                                        <p class="text-gray-600 text-sm">{{ $message }}</p>
                                    </div>
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                    <di class="col-md-6 mt-4">
                        <label class="text-gray-700" for="id_number">NO KK /NIK Orang tua/Wali</label>
                        <input class="form-input w-full mt-2 rounded-md bg-gray-200 focus:bg-white" type="text" name="no_kk" value="{{ old('no_kk') }}" placeholder="Masukan No KK yang Benar !">
                        @error('no_kk')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </di>

                    <di class="col-md-6 mt-4">
                        <label class="text-gray-700" for="id_number">TEMPAT & TANGGAL LAHIR</label>
                        <div class="row">
                            <div class="col-md-7">
                                <input class="form-input w-full mt-2 rounded-md bg-gray-200 focus:bg-white" type="text" name="birth_place" value="{{ old('birth_place') }}" placeholder="Place of birth">
                                @error('birth_place')
                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                        <div class="px-4 py-2">
                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                        </div>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <input class="form-input w-full mt-2 rounded-md bg-gray-200 focus:bg-white p-3" type="date" name="birth_date" value="{{ old('birth_date') }}">
                                @error('birth_date')
                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                        <div class="px-4 py-2">
                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                        </div>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                    </di>
                    <di class="col-md-6 mt-4">
                        <label class="text-gray-700" for="phone">No Handphone</label>
                        <input class="form-input w-full mt-2 rounded-md bg-gray-200 focus:bg-white" type="text" name="phone" value="{{ old('phone') }}" placeholder="Masukan No Handphone !">
                        @error('phone')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </di>

                    <div class="col-md-6 mt-4">
                        <label class="text-gray-700" for="address">Alamat Lengkap</label>
                        <textarea class="w-full mt-2 rounded-md bg-gray-200 focus:bg-white" name="address" rows="7">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </div>

                    <di class="col-md-6 mt-4">
                        <label class="text-gray-700" for="email">Email</label>
                        <input class="form-input w-full mt-2 rounded-md bg-gray-200 focus:bg-white" type="email" name="email" value="{{ old('email') }}" placeholder="Masukan Email !">
                        @error('email')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </di>


                <div class="flex justify-start mt-4">
                    <button type="submit" class="px-4 py-2 bg-gray-600 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700">SIMPAN</button>
                </div>
            </form>
        </div>
        
    </div>
    <script>
        @if(session()->has('success'))

        Swal.fire({
            icon: 'success',
            title: 'BERHASIL!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000
        })

        @elseif(session()->has('error'))

        Swal.fire({
            icon: 'error',
            text: 'GAGAL!',
            title: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 3000
        })

        @endif
    </script>
<script>
function getKecamatans() {
    let kabupatenId = $('#kabupaten_id').val();

    $.ajax({
        url: '/formdaftar/get-kecamatans/' + kabupatenId,
        type: 'GET',
        success: function (kecamatans) {
            $('#kecamatan_id').empty();
            $('#kecamatan_id').append('<option value="">Pilih Kecamatan</option>');

            kecamatans.forEach(function (kecamatan) {
                $('#kecamatan_id').append('<option value="' + kecamatan.id + '">' + kecamatan.nama + '</option>');
            });
        }
    });
}

function getDesas() {
    let kecamatanId = $('#kecamatan_id').val();

    $.ajax({
        url: '/formdaftar/get-desas/' + kecamatanId,
        type: 'GET',
        success: function (desas) {
            $('#desa_id').empty();
            $('#desa_id').append('<option value="">Pilih Desa</option>');

            desas.forEach(function (desa) {
                $('#desa_id').append('<option value="' + desa.id + '">' + desa.nama + '</option>');
            });
        }
    });
}
</script>

@endsection

