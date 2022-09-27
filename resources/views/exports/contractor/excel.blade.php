@extends('exports.template')

@section('content')
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama PIC</th>
                <th>Nama Perusahaan</th>
                <th>Email</th>
                <th>No. Telepon</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contractors as $contractor)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $contractor->pic_name }}</td>
                    <td>{{ $contractor->company_name }}</td>
                    <td>{{ $contractor->email }}</td>
                    <td>{{ $contractor->phone }}</td>
                    <td>{{ $contractor->address }}</td>
                    <td>{{ $contractor->status == 1 ? 'Aktif' : 'Non-Aktif' }}</td>
                    <td><img height="100" width="100" src="{{ url('storage/' . $contractor->image) }}" alt="{{ $contractor->company_name }}"></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
