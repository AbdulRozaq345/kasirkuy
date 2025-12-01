<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kasir - {{ $title ?? 'Page' }}</title>

    {{-- Style --}}
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/iconly.css') }}">
    {{-- Icon --}}
    <link rel="stylesheet" href="{{ asset('mazer/assets/extensions/@fortawesome/fontawesome-free/css/all.min.css') }}">
    @livewireStyles
</head>

<body>

    <div id="app">
        <div id="sidebar">
            @include('layouts.partials.sidebar') {{-- memanggil sidebar yang akan kita buat --}}
        </div>

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

           {{ $slot }} {{-- Nanti isi $slot disini, tapi kita membuat CRUD produk dahulu --}}
        </div>

    </div>

    {{-- Icon --}}
    <script src="{{ asset('mazer/assets/extensions/@fortawesome/fontawesome-free/js/all.min.js') }}"></script>

    <script src="{{ asset('mazer/assets/static/js/initTheme.js') }}"></script>
    <script src="{{ asset('mazer/assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('mazer/assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('mazer/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('mazer/assets/extensions/sweetalert2/sweetalert2.all.min.js') }}"></script>
    @livewireScripts

</body>

{{-- Sweetalert2 --}}
{{-- Success --}}
@if (session('success'))
    <script>
        Swal.fire({
            position: "top",
            title: "{{ session('success') }}",
            icon: "success",
            showConfirmButton: false,
            toast: true,
            timer: 2500,
        });
    </script>
@endif

{{-- Error --}}
@if (session('error'))
    <script>
        Swal.fire({
            position: "top",
            title: "{{ session('error') }}",
            icon: "success",
            showConfirmButton: false,
            toast: true,
            timer: 2500,
        });
    </script>
@endif

{{-- Info --}}
@if (session('info'))
    <script>
        Swal.fire({
            position: "top-end",
            title: "{{ session('info') }}",
            icon: "info",
            showConfirmButton: false,
            toast: true,
            timer: 2500,
        });
    </script>
@endif

{{-- Konfirmasi Penghapusan --}}
<script>
    function konfirmasiHapus(id) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda tidak akan bisa mengembalikannya!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('hapus', {
                    id: id
                });
            }
        });
    }
</script>


</html>
