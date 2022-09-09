@extends('exports.template')

@section('content')
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
@endsection
