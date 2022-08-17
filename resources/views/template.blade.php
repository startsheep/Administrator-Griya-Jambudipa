<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    {{-- <link rel="shortcut icon" type="image/png" href="{{ url('images/logo.png') }}" /> --}}
    <title>Administrator Griya Jambudipa</title>
</head>

<body>
    @yield('content')
    @vite('resources/js/app.js')
    {{-- @stack('js') --}}
</body>

</html>
