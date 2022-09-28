@extends('exports.template')

@section('content')
    <table style="font-family: sans-serif">
        <thead style="text-transform: uppercase; background-color: rgb(60, 60, 194); color: white">
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>No Telepon</th>
                <th>Blok / Kavling</th>
                <th>Tipe Rumah</th>
                <th>Harga Rumah</th>
                <th>Sisa Asuransi</th>
                <th>Tipe Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $payment['customer']->name }}</td>
                    <td>{{ $payment['customer']->phone }}</td>
                    <td>{{ $payment['block']->block . ' / ' . $payment['block']->number_kavling }}</td>
                    <td>{{ $payment['block']->houseType->house_type }}</td>
                    <td>Rp. {{ number_format($payment['block']->houseType->price, 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($payment['reminder_payment'], 0, ',', '.') }}</td>
                    <td>{{ $payment['type'] }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
