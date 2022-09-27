@php
$total = 0;
$price = 0;
function changeToRomawi($nomor)
{
    switch ($nomor) {
        case 1:
            return 'I';
            break;
        case 2:
            return 'II';
            break;
        case 3:
            return 'III';
            break;
        case 4:
            return 'IV';
            break;
        case 5:
            return 'V';
            break;
        case 6:
            return 'VI';
            break;
        case 7:
            return 'VII';
            break;
        case 8:
            return 'VIII';
            break;
        case 9:
            return 'XI';
            break;
        case 10:
            return 'X';
            break;

        default:
            return 0;
            break;
    }
}
@endphp
@extends('exports.template')

@section('content')
    <table style="font-family: sans-serif">
        <thead style="text-transform: uppercase; background-color: rgb(60, 60, 194); color: white">
            <tr>
                <th>No.</th>
                <th>Uraian</th>
                <th>Vol</th>
                <th>Sat</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($buildings as $building)
                @if ($building->id != 1)
                    <tr style="background-color: rgb(255, 238, 206)">
                        <th>{{ changeToRomawi($loop->iteration - 1) }}</th>
                        <td colspan="6">
                            <span style="font-weight: bold">{{ $building->category }}</span>
                        </td>
                    </tr>
                    <tr>
                        @foreach ($building->basicPrice as $basicPrice)
                            @php
                                $total += $basicPrice->total;
                                $price += $basicPrice->price;
                            @endphp
                            <td style="text-align: center">{{ $loop->iteration }}</td>
                            <td>{{ $basicPrice->description }}</td>
                            <td>{{ number_format($basicPrice->volume, 2, ',', '.') }}</td>
                            <td>{{ $basicPrice->unit }}</td>
                            <td>{{ $basicPrice->price == 0 ? '' : 'Rp. ' . number_format($basicPrice->price, 0, '', '.') }}
                            </td>
                            <td>{{ $basicPrice->amount }}</td>
                            <td>{{ $basicPrice->total == 0 ? '' : 'Rp. ' . number_format($basicPrice->total, 0, '', '.') }}
                            </td>
                    </tr>
                    <tr>
                        @foreach ($basicPrice->child as $child)
                            @php
                                $total += $child->total;
                                $price += $child->price;
                            @endphp
                    <tr>
                        <td style="text-align: center"></td>
                        <td>{{ $child->description }}</td>
                        <td>{{ number_format($child->volume, 2, ',', '.') }}</td>
                        <td>{{ $child->unit }}</td>
                        <td>{{ $child->price == 0 ? '' : 'Rp. ' . number_format($child->price, 0, '', '.') }}</td>
                        <td>{{ $child->amount }}</td>
                        <td>{{ $child->total == 0 ? '' : 'Rp. ' . number_format($child->total, 0, '', '.') }}</td>
                    </tr>
                @endforeach
            @endforeach
            @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6" style="text-transform: uppercase">Total Biaya</th>
                <th>{{ $total == 0 ? '-' : 'Rp. ' . number_format($total, 0, ',', '.') }}</th>
            </tr>
            <tr>
                <th colspan="6" style="text-transform: uppercase">Harga Dasar Tanah Per M<sup>2</sup></th>
                <th>{{ $price == 0 ? '-' : 'Rp. ' . number_format($price, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
@endsection
{{-- <table>
    <thead>
        <tr>
            <th>asas</th>
        </tr>
    </thead>
</table> --}}
