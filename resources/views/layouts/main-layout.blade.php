    <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>General Dashboard &mdash; Stisla</title>

  <!-- General CSS Files -->

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  {{-- <link rel="stylesheet" href="../../../node_modules/jqvmap/dist/jqvmap.min.css">
  <link rel="stylesheet" href="../../../node_modules/weathericons/css/weather-icons.min.css">
  <link rel="stylesheet" href="../../../node_modules/weathericons/css/weather-icons-wind.min.css">
  <link rel="stylesheet" href="../../../node_modules/summernote/dist/summernote-bs4.css"> --}}


  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
        @include('layouts.navbar')
        @include('layouts.sidebar')
      <!-- Main Content -->
      <div class="main-content">
        @yield('content')
        </section>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad Nauval Azhar</a>
        </div>
        <div class="footer-right">
          2.3.0
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  {{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script> --}}
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> --}}
  {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> --}}
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script> --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('assets/js/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/stisla.js') }}"></script>
  <!-- JS Libraies -->
  {{-- <script src="../../../node_modules/simpleweather/jquery.simpleWeather.min.js"></script>
  <script src="../../../node_modules/chart.js/dist/Chart.min.js"></script>
  <script src="../../../node_modules/jqvmap/dist/jquery.vmap.min.js"></script>
  <script src="../../../node_modules/jqvmap/dist/maps/jquery.vmap.world.js"></script>
  <script src="../../../node_modules/summernote/dist/summernote-bs4.js"></script>
  <script src="../../../node_modules/chocolat/dist/js/jquery.chocolat.min.js"></script> --}}

  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js')}}"></script>

  <!-- Page Specific JS File -->
  {{-- <script src="../../../assets/js/page/index-0.js"></script> --}}
</body>
</html>
