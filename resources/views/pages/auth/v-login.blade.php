<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login</title>

    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.1.2-web/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/third-party/izitoast/dist/css/iziToast.min.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">


</head>

<body class="bg-dark">
    <div id="app ">
        <section class="section ">
            <div class="container mt-5">
                <div class="row ">
                    <div
                        class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="card card-primary">
                            {{-- <div class="card-header ">
                <h4 class="text-center">Login</h4>
              </div> --}}

                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <img src="{{ asset('assets/images/logo.png') }}"
                                            class="img-fluid rounded mx-auto d-block" alt="">
                                        <h4 class="text-center">Log in</h4>
                                    </div>
                                </div>
                                <div class="needs-validation" novalidate="">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control" name="email"
                                            tabindex="1" required autofocus>
                                        <div class="invalid-feedback">
                                            Please fill in your email
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                            <div class="float-right">
                                                <a href="auth-forgot-password.html" class="text-small">
                                                    Forgot Password?
                                                </a>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <input id="password" type="password" class="form-control" name="password"
                                                tabindex="2" required>
                                            <div class="input-group-append">

                                                <span id="hide-password" class="btn btn-primary">
                                                    <i class="fa-solid fa-eye"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">
                                            please fill in your password
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            {{-- <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Remember Me</label> --}}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button id="btn-login" type="submit" class="btn btn-primary btn-lg btn-block"
                                            tabindex="4">
                                            Login
                                        </button>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="simple-footer">
                            {{-- Copyright &copy; Stisla 2018 --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/third-party/izitoast/dist/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>

    <script type="module">
        import Cookies from "{{ asset('assets/js/js-cookie/dist/js.cookie.mjs') }}";

        if (Cookies.get('user')) {
            window.location.href = "{{ url('/dashboard') }}";
        }

        $(document).ready(function() {
            // who2-hie3 pqww2o4e
            $('#hide-password').on('click', function() {
                var password = $('#password');
                var icon = $(this).find('i');
                if (password.attr('type') == 'password') {
                    password.attr('type', 'text');
                    icon.removeClass('fa-eye');
                    icon.addClass('fa-eye-slash');
                } else {
                    password.attr('type', 'password');
                    icon.removeClass('fa-eye-slash');
                    icon.addClass('fa-eye');
                }
            });
            //setup ajax to create login
            $('#btn-login').on('click', function(e) {
                // get value from input
                let email = $('#email').val();
                let password = $('#password').val();
                let url = "{{ url('api/auth/login') }}";
                // crete ajax.setup with csrftoken
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                // setup ajax
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        email: email,
                        password: password
                    },
                    success: function(data) {

                        console.log(data);
                        if (data.data) {
                            // set cookie

                            // $.cookie('user', data.data, {
                            //     expires: 1
                            // });
                            Cookies.set('user', data.data);

                            iziToast.success({
                                title: 'Berhasil',
                                message: 'Berhasil Masuk',
                                timeout: 1000,
                                position: 'topCenter',
                                progressBar: false,
                                onOpened: function() {
                                    window.location.href =
                                        "{{ url('/dashboard') }}";
                                }
                            });

                        }
                    },
                    error : function(data) {
                        iziToast.error({
                                title: "Gagal",
                                message: 'Periksa Email dan Password',
                                timeout: 2000,
                                position: 'topCenter',
                                progressBar: false,

                            })
                    }
                });
            });
        });
    </script>
    <script type="module">

        </script>
    <!-- Page Specific JS File -->
</body>

</html>
