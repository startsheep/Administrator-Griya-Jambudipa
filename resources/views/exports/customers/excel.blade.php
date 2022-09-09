@extends('exports.template')

@section('content')
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No. Telepon</th>
                <th>Profesi</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Blok/Kavling</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $customer->name }}</td>
                    <td><a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a></td>
                    <td><a href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a></td>
                    <td>{{ $customer->profession }}</td>
                    <td>{{ $customer->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>{{ $customer->is_active == 1 ? 'Aktif' : 'Non-Aktif' }}</td>
                    <td>
                        @foreach ($customer->customerKavling as $kavling)
                            {{ $kavling->kavling->block . '-' . $kavling->kavling->number_kavling . '/' . $kavling->kavling->houseType->house_type }}
                        @endforeach
                    </td>
                    <td><img src="{{ url('storage/' . $customer->image) }}" alt="{{ $customer->name }}" height="100"
                            width="100"></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
