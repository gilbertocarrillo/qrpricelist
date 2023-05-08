@props(['title'])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <title>{{ $title }}</title>
</head>

<body>
    <div class="bg-light">
        {{ $slot }}
    </div>
</body>

</html>
