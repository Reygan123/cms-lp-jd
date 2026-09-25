@extends('layouts.app', ['title' => 'Tambah Data Anggota - Admin'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <div class="container mx-auto px-6 py-8">

        <div class="p-6 bg-white rounded-md shadow-md">
            <h2 class="text-lg text-gray-700 font-semibold capitalize">TAMBAH DATA ANGGOTA</h2>
            <hr class="mt-4">
            <form action="{{ route('admin.formdaftar.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mt-4">
                        <label class="text-gray-700" for="image">FOTO (Background Usaha)</label>
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
                        <label class="text-gray-700" for="name">NAMA LENGKAP CALON ANGGOTA</label>
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
                            <label class="text-gray-700" for="image">Tanda Pengenal</label>
                            <select class="w-full border bg-gray-200 focus:bg-white rounded px-3 py-2 outline-none" aria-label=".form-select-sm example" name="tanda_pengenal">
                                <option selected>Pilih Tanda Pengenal</option>
                                <option value="KTP">KTP</option>
                                <option value="SIM">SIM</option>
                                <option value="PASSPORT">PASSPORT</option>
                            </select>
                            @error('tanda_pengenal')
                                <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                    <div class="px-4 py-2">
                                        <p class="text-gray-600 text-sm">{{ $message }}</p>
                                    </div>
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                    <di class="col-md-6 mt-4">
                        <label class="text-gray-700" for="id_number">NO KTP / NO SIM / NOMOR PASPOR</label>
                        <input class="form-input w-full mt-2 rounded-md bg-gray-200 focus:bg-white" type="text" name="id_number" value="{{ old('id_number') }}" placeholder="ID Number or Passport">
                        @error('id_number')
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
                        <label class="text-gray-700" for="phone">NOMOR HANDPHONE CALON MEMBER</label>
                        <input class="form-input w-full mt-2 rounded-md bg-gray-200 focus:bg-white" type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone Number">
                        @error('phone')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </di>

                    <div class="col-md-6 mt-4">
                        <label class="text-gray-700" for="address">ALAMAT LENGKAP</label>
                        <textarea class="w-full mt-2 rounded-md bg-gray-200 focus:bg-white" name="address" rows="7">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </div>
                    <hr class="mt-4 mb-4">
                    <h3>Data Perusahaan</h3>
                    <di class="col-md-6 mt-4">
                        <label class="text-gray-700" for="nama_perusahaan">NAMA PERUSAHAAN</label>
                        <input class="form-input w-full mt-2 rounded-md bg-gray-200 focus:bg-white" type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan') }}" placeholder="Nama Perusahaan Sesuai Izin">
                        @error('nama_perusahaan')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </di>
                    <di class="col-md-6 mt-4">
                        <label class="text-gray-700" for="category">KATEGORI USAHA</label>
                        <input class="form-input w-full mt-2 rounded-md bg-gray-200 focus:bg-white" type="text" name="category" value="{{ old('category') }}" placeholder="Kategori Usaha">
                        @error('category')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </di>
                    <di class="col-md-6 mt-4">
                        <label class="text-gray-700" for="phone_perusahaan">NO. TELEPON PERUSAHAAN</label>
                        <input class="form-input w-full mt-2 rounded-md bg-gray-200 focus:bg-white" type="text" name="phone_perusahaan" value="{{ old('phone_perusahaan') }}" placeholder="Nomor telepon perusahaan">
                        @error('phone_perusahaan')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </di>
                    <di class="col-md-6 mt-4">
                        <label class="text-gray-700" for="email">EMAIL PERUSAHAAN</label>
                        <input class="form-input w-full mt-2 rounded-md bg-gray-200 focus:bg-white" type="text" name="email" value="{{ old('email') }}" placeholder="Alamat email perusahaan">
                        @error('email')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </di>
        
                    <div class="col-12 mt-4">
                        <label class="text-gray-700" for="description">DESKRIPSI PERUSAHAAN</label>
                        <textarea class="w-full mt-2 rounded-md bg-gray-200 focus:bg-white" name="description" rows="7">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="text-gray-700" for="alamat_perusahaan">ALAMAT PERUSAHAAN</label>
                        <textarea class="w-full mt-2 rounded-md bg-gray-200 focus:bg-white" name="alamat_perusahaan" rows="7">{{ old('alamat_perusahaan') }}</textarea>
                        @error('alamat_perusahaan')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="text-gray-700" for="name">Provinsi</label>
                        <select class="w-full border bg-gray-200 focus:bg-white rounded px-3 py-2 outline-none" aria-label=".form-select-sm example" name="kota">
                            <option selected>Jawa Barat</option>
                        </select>
                        <div class="mt-4">
                            <label class="text-gray-700" for="kabupaten_id">Kota</label>
                            <select name="kabupaten_id" id="kabupaten_id" class="form-control" onchange="getKecamatans()">
                                <option value="">Pilih Kota</option>
                                @foreach ($kabupatens as $kabupaten)
                                    <option value="{{ $kabupaten->id }}">{{ $kabupaten->name }}</option>
                                @endforeach
                            </select>
                            @error('kabupaten_id')
                                <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                    <div class="px-4 py-2">
                                        <p class="text-gray-600 text-sm">{{ $message }}</p>
                                    </div>
                                </div>
                            @enderror
                            <br>
                    </div>
                    <div class="mt-4">
                        <label class="text-gray-700" for="name">KECAMATAN</label>
                        <select name="kecamatan_id" id="kecamatan_id" class="form-control" onchange="getDesas()">
                            <option value="">Pilih Kecamatan</option>
                            @foreach ($kecamatans as $kecamatan)
                                <option value="{{ $kecamatan->id }}">{{ $kecamatan->name }}</option>
                            @endforeach
                        </select>
                        @error('kecamatan_id')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <label class="text-gray-700" for="name">KELURAHAN</label>
                        <select name="desa_id" id="desa_id" class="form-control">
                        <option value="">Pilih Kelurahan</option>
                            @foreach ($desas as $desa)
                                <option value="{{ $desa->id }}">{{ $desa->name }}</option>
                            @endforeach
                        </select>
                        @error('desa_id')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </div>
                    </div>
                    
                </div>


                <div class="flex justify-start mt-4">
                    <button type="submit" class="px-4 py-2 bg-gray-600 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700">SIMPAN</button>
                </div>
            </form>
        </div>
        
    </div>
</main>
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
