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
            <th>Status Kepagawaian</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $employee)
            <tr>
                <th>{{ $loop->iteration }}</th>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->position->name }}</td>
                <td>Rp. {{ number_format($employee->position->salary, 0, ',', '.') }}</td>
                <td>{{ $employee->is_active == 1 ? 'Aktif' : 'Non-Aktif' }}</td>
                <td>{{ $employee->status == 1 ? 'Pegawai Tetap' : 'Pegawai Tidak Tetap' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@if (Request::segment(3) == 'print')
    <script>
        window.print()
    </script>
@endif
