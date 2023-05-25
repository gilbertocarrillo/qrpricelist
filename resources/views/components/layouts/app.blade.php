@props(['title'])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <link href="{{ asset('DataTables/datatables.min.css') }}" rel="stylesheet" />
    <title>{{ $title }}</title>
</head>

<body>
    <div class="bg-light">
        {{ $slot }}
    </div>
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    @yield('scripts')
</body>

</html>
