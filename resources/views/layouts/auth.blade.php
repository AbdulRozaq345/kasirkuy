<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Kasir - {{ $title ?? 'Page' }}</title>
		{{-- 
		    // Jika variabel $title ada dan memiliki nilai, tampilkan nilainya.
		    // Jika $title tidak ada atau nilainya null, gunakan 'Page' sebagai nilai default.
		--}}
    
    {{-- Style --}}
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/auth.css') }}">
    
    {{-- Icon --}}
    <link rel="stylesheet" href="{{ asset('mazer/assets/extensions/@fortawesome/fontawesome-free/css/all.min.css') }}">
    @livewireStyles
</head>

<body>

    <div id="auth">

        {{ $slot }} {{-- disini tempat component livewire kita nanti --}}

    </div>

    {{-- Icon --}}
    <script src="{{ asset('mazer/assets/extensions/@fortawesome/fontawesome-free/js/all.min.js') }}"></script>
    
    <script src="{{ asset('mazer/assets/static/js/initTheme.js') }}"></script>
    <script src="{{ asset('mazer/assets/extensions/sweetalert2/sweetalert2.all.min.js') }}"></script>
    @livewireScripts

</body>

{{-- SweetAlert2 untuk notifikasi sukses --}}
{{-- Success --}}
@if (session('success-message'))
    <script>
        Swal.fire({
            position: "top",
            title: "{{ session('success-message') }}",
            icon: "success",
            showConfirmButton: false,
            toast: true,
            timer: 2500,
        });
    </script>
@endif

</html>
