@extends('layouts.app', ['title' => 'Profile - Admin'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto">
    <div class="container mx-auto px-6 py-8">

        @if (session('status'))
        <div class="bg-green-500 p-3 rounded-md shadow-sm mt-3">
            @if (session('status')=='profile-information-updated')
            Profile has been updated.
            @endif
            @if (session('status')=='password-updated')
            Password has been updated.
            @endif
            @if (session('status')=='two-factor-authentication-disabled')
            Two factor authentication disabled.
            @endif
            @if (session('status')=='two-factor-authentication-enabled')
            Two factor authentication enabled.
            @endif
            @if (session('status')=='recovery-codes-generated')
            Recovery codes generated.
            @endif
        </div>
        @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
                                <div class="p-6 bg-white rounded-md shadow-md">
                                    <h4 class="capitalize">TWO-FACTOR AUTHENTICATION</h4>
                                    <hr class="mt-4">
            
                                    <div class="mt-4">
                                        @if(! auth()->user()->two_factor_secret)
                                        {{-- Enable 2FA --}}
                                        <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                                            @csrf
            
                                            <button type="submit"
                                                class="btn btn-primary btn btn-lg">
                                                Enable Two-Factor
                                            </button>
                                        </form>
                                        @else
                                        {{-- Disable 2FA --}}
                                        <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                                            @csrf
                                            @method('DELETE')
            
                                            <button type="submit"
                                                class="px-4 py-2 bg-red-600 text-gray-200 rounded-md hover:bg-red-900 focus:outline-none focus:bg-gray-700">
                                                Disable Two-Factor
                                            </button>
                                        </form>
            
                                        @if(session('status') == 'two-factor-authentication-enabled')
                                        {{-- Show SVG QR Code, After Enabling 2FA --}}
                                        <div class="mt-4">
                                            Otentikasi dua faktor sekarang diaktifkan. Pindai kode QR berikut menggunakan aplikasi
                                            pengautentikasi ponsel Anda.
                                        </div>
            
                                        <div class="mb-3 mt-4">
                                            {!! auth()->user()->twoFactorQrCodeSvg() !!}
                                        </div>
                                        @endif
            
                                        {{-- Show 2FA Recovery Codes --}}
                                        <div class="mt-4">
                                            Simpan recovery code ini dengan aman. Ini dapat digunakan untuk memulihkan akses ke akun
                                            Anda jika perangkat otentikasi dua faktor Anda hilang.
                                        </div>
            
                                        <div style="background: rgb(44, 44, 44);color:white" class="rounded p-3 mb-2 mt-4">
                                            @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                                            <div>{{ $code }}</div>
                                            @endforeach
                                        </div>
            
                                        {{-- Regenerate 2FA Recovery Codes --}}
                                        <form method="POST" action="{{ url('user/two-factor-recovery-codes') }}">
                                            @csrf
            
                                            <button type="submit"
                                                class="mt-4 px-4 py-2 bg-gray-600 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700">
                                                Regenerate Recovery Codes
                                            </button>
                                        </form>
                                        @endif
                                    </div>
            
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="p-6 bg-white rounded-md shadow-md">
                                <h4 class="">Edit Profile</h4>
                                <hr class="mt-4">
                                <form class="mt-4" action="{{ route('user-profile-information.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label class="text-label" for="name">Full Name</label>
                                        <input class="form-control" type="text" name="name" value="{{ old('name') ?? auth()->user()->name }}">
                                        @error('name')
                                        <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                            <div class="px-4 py-2">
                                                <p class="text-gray-600 text-sm">{{ $message }}</p>
                                            </div>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mt-4">
                                        <label class="text-label" for="email">Email</label>
                                        <input class="form-control" type="email" name="email" value="{{ old('email') ?? auth()->user()->email }}">
                                        @error('email')
                                        <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                            <div class="px-4 py-2">
                                                <p class="text-gray-600 text-sm">{{ $message }}</p>
                                            </div>
                                        </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mt-4">
                                        <button type="submit"
                                            class="btn btn-primary">UPDATE
                                            PROFILE</button>
                                    </div>
                                </form>
                            </div>
            
                            <div class="mt-5">
                                <h4 class="">Update Password</h4>
                                <hr class="mt-2">
                                <form class="mt-4" action="{{ route('user-password.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group mt-4 row">
                                        <label class="col-sm-3 col-form-label" for="current_password">Old Password</label>
                                        <input class="col-sm-9 form-control" type="password" name="current_password">
                                        @error('current_password')
                                        <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                            <div class="px-4 py-2">
                                                <p class="text-gray-600 text-sm">{{ $message }}</p>
                                            </div>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mt-4 row">
                                        <label class="col-sm-3 col-form-label" for="password">New Password</label>
                                        <input class="col-sm-9 form-control" type="password" name="password">
                                        @error('password')
                                        <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                            <div class="px-4 py-2">
                                                <p class="text-gray-600 text-sm">{{ $message }}</p>
                                            </div>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mt-4 row">
                                        <label class="col-sm-3 col-form-label" for="password">New Password Confirmation</label>
                                        <input class="col-sm-9 form-control" type="password" name="password_confirmation">
                                        <span id="password-mismatch" class="text-danger mt-2" style="display: none;">Password tidak cocok.</span>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <button type="submit"
                                            class="btn btn-primary">UPDATE
                                            PASSWORD</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center my-3">
                            <h4 class="card-title">Role User <span class="badge badge-primary" data-toggle="modal"
                                    data-target="#exampleModalCenter">+ Tambah User Baru</span></h4>
                            <form method="GET" action="{{ route('admin.profile.index') }}" class="mb-3 col-6">
                                <div class="input-group">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        class="form-control" placeholder="Cari pengguna...">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <th>{{ $loop->iteration }}</th>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td class="color-primary">
                                                <span class="badge badge-warning" data-toggle="modal"
                                                    data-target="#editUserModal{{ $user->id }}">Edit</span>
                                            </td>
                                        </tr>
                                        <!-- Modal Edit User -->
                                        <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
                                            aria-labelledby="editUserModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editUserModalLabel">Edit Pengguna</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="POST"
                                                        action="{{ route('admin.profile.update', $user->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="name" class="form-label">Nama</label>
                                                                <input type="text" name="name" class="form-control"
                                                                    value="{{ $user->name }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="email" class="form-label">Email</label>
                                                                <input type="email" name="email" class="form-control"
                                                                    value="{{ $user->email }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="password" class="form-label">Password</label>
                                                                <input type="password" name="password" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Tutup</button>
                                                            <button type="submit" class="btn btn-primary">Simpan
                                                                Perubahan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- end modal --}}
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $users->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
</main>
<!-- Modal -->
    <div class="modal fade" id="exampleModalCenter">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.profile.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" aria-describedby="name"
                                name="name">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">password</label>
                            <input type="password" class="form-control" id="password" aria-describedby="password"
                                name="password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');

        const mismatchMessage = document.getElementById('password-mismatch');

        confirmPasswordInput.addEventListener('input', () => {
            if (passwordInput.value !== confirmPasswordInput.value) {
                mismatchMessage.style.display = 'block';
            } else {
                mismatchMessage.style.display = 'none';

            }
        });
    </script>
@endsection