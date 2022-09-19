<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.1.2-web/css/all.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}" />
    <title>Administrator Griya Jambudipa</title>
</head>

<body>
    @yield('content')
    @vite('resources/js/app.js')
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script>
        loadProfile();

        function loadProfile() {
            $.get("/api/company-profile", function(response) {
                $(document).attr("title", response.data.name)
                if (response.data.logo == null) {
                    $("link[rel='shortcut icon']").attr("href", "{{ asset('assets/images/logo.png') }}")
                    $("#logo").attr("src", "{{ asset('assets/images/logo.png') }}")
                } else {
                    $("link[rel='shortcut icon']").attr("href", '/storage/' + response.data.logo)
                    $("#logo").attr("src", '/storage/' + response.data.logo)
                }
            })
        }
    </script>
</body>

</html>
