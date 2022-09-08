<style>
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

<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Divisi</th>
            <th>Gaji</th>
            <th>Status Keaktifan</th>
            <th>Status Kepegawaian</th>
            <th>Foto</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $employee)
            <tr>
                <th>{{ $loop->iteration }}</th>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->position->name }}</td>
                @if ($employee->position->name == 'Marketing')
                    @php
                        $total = 0;
                        foreach ($employee->payment as $salary) {
                            $total += $salary->commission;
                        }
                    @endphp
                    <td>Rp. {{ number_format($total, 0, ',', '.') }}</td>
                @else
                    <td>Rp. {{ number_format($employee->position->salary, 0, ',', '.') }}</td>
                @endif
                <td>{{ $employee->is_active == 1 ? 'Aktif' : 'Non-Aktif' }}</td>
                <td>{{ $employee->status == 1 ? 'Pegawai Tetap' : 'Pegawai Tidak Tetap' }}</td>
                <td><img src="{{ url('storage/' . $employee->image) }}" alt="{{ $employee->name }}" height="100"
                        width="100"></td>
            </tr>
        @endforeach
    </tbody>
</table>

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
</script>

@if (Request::segment(3) == 'print')
    <script>
        window.print()
    </script>
@endif
