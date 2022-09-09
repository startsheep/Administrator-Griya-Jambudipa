<button style="margin-block: 20px" onclick="printTable()">Cetak</button>
<button style="margin-block: 20px" onclick="history.back(-1)">Kembali</button>

<div id="frame">
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
        }
    </style>
    @yield('content')
</div>

<iframe id="print-frame" name="print_frame" src="about:blank" style="display: none"></iframe>

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"
    integrity="sha512-3j3VU6WC5rPQB4Ld1jnLV7Kd5xr+cq9avvhwqzbH/taCRNURoeEpoPBK9pDyeukwSxwRPJ8fDgvYXd6SkaZ2TA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    let token = $.cookie('token')

    if (!token) {
        $("table").html('');
        location.href = "/auth/login";
    }

    let table = document.querySelector("#frame").innerHTML;
    window.frames["print_frame"].document.title = document.title;
    window.frames["print_frame"].document.body.innerHTML = table;
    window.frames["print_frame"].window.focus();

    function printTable() {
        window.frames["print_frame"].window.print();
    }
</script>
