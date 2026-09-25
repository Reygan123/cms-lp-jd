<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    @foreach ($identities as $q)
    <link rel="shortcut icon" type="image/jpg" href="{{asset('storage/identities/'.$q->favicon)}}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} - {{ $q->name }}</title>
    @endforeach
    <!-- css -->
{{--      
    <link rel="stylesheet" href="{{ asset('vendor/tailwind/tailwind.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/all.min.css') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet"> --}}

    {{-- css baru --}}
    <link rel="stylesheet" href="{{asset('admin/vendor/dropify/dist/css/dropify.min.css')}}">
    <link href="{{asset('admin/vendor/jqvmap/css/jqvmap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('admin/vendor/bootstrap-daterangepicker/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{asset('admin/vendor/jquery-steps/css/jquery.steps.css')}}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-icons.min.css') }}">
    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/endar.css')}}" rel="stylesheet">

    {{-- css baru end  --}}

    <!-- js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.1/dist/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script>
    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/super-build/latest/ckeditor.js"></script> -->
</head>

<body>
    <div id="preloader">
        <div class="spinner">
            <div class="spinner-a"></div>
            <div class="spinner-b"></div>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="nav-header">
            <a href="{{ route('home') }}" class="brand-logo">
                <span class="logo-abbr">{{ asset('storage/identities/' . $identities[0]->favicon) }}</span>
                <span class="logo-compact"><img src="{{ asset('storage/identities/' .$identities[0]->logo) }}"
                        alt="{{ $identities[0]->name }}" class="logo"></span>
                <span class="brand-title"><img src="{{ asset('storage/identities/' .$identities[0]->logo) }}"
                        alt="{{ $identities[0]->name }}"></span>
            </a>

            <div class="nav-control wave-effect wave-effect-x">
                <div class="hamburger">
                    <span class="toggle-icon"><i class="icon-menu"></i></span>
                </div>
            </div>
        </div>

        @include('layouts.header')
        @include('layouts.nav')
        <div class="content-body">
            @yield('content')
        </div>
        @include('layouts.footer')



    </div>

    {{-- <script src="{{ asset('vendor/tailwind/tailwind.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/fontawesome/all.min.js') }}"></script> --}}

    {{-- js baru  --}}
    

    <script src="{{ asset('vendor/fontawesome/all.min.js') }}"></script>

    <!-- Required vendors -->
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- Here is navigation script -->
    <script src="{{ asset('admin/vendor/quixnav/quixnav.min.js') }}"></script>
    <script src="{{ asset('admin/js/quixnav-init.js') }}"></script>
    <script src="{{ asset('admin/js/custom.min.js') }}"></script>
    <!--removeIf(production)-->
    <!-- Demo scripts -->
    <script src="{{ asset('admin/js/styleSwitcher.js') }}"></script>
    <!--endRemoveIf(production)-->


    <!-- Daterange picker library -->
    <script src="{{ asset('admin/vendor/moment/moment.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap-daterangepicker/daterangepicker.js') }}"></script>


    <!-- Vectormap -->
    <script src="{{ asset('admin/vendor/jqvmap/js/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/jqvmap/js/jquery.vmap.world.js') }}"></script>

    <!-- Dropify -->
    <script src="{{ asset('admin/vendor/dropify/dist/js/dropify.min.js') }}"></script>
    <!-- Dropify init -->
    <script src="{{ asset('admin/js/plugins-init/dropify-init.js') }}"></script>

    <!-- daterangepicker init -->
    <!-- <script src="./js/plugins-init/card-headerdatepicker-init.js"></script> -->


    <script src="{{ asset('admin/vendor/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/js/dashboard/dashboard-1.js') }}"></script>

    <script src="{{ asset('assets/js/custom.js') }}"></script>

    {{-- end js baru  --}}

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
</body>
</html>