@php
$totalHouse = 0;
$totalLand = 0;
$totalBuild = 0;

function countLandArea($result)
{
    $total = 0;

    foreach ($result as $item) {
        if ($item->area_kavling) {
            $total += $item->area_kavling;
        }
    }

    return $total;
}

function countBuildingArea($result)
{
    $total = 0;

    foreach ($result as $item) {
        if ($item->area_building) {
            $total += $item->area_building;
        }
    }

    return $total;
}
@endphp

@extends('exports.template')

@section('content')
    <table style="margin-bottom: 20px">
        <thead>
            <tr>
                <th>Tipe Rumah</th>
                <th>Jumlah (Unit)</th>
                <th>Total Luas Tanah (M<sup>2</sup>)</th>
                <th>Total Luas Bangunan (M<sup>2</sup>)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($houseTypes as $type)
                @php
                    $kavlingByType = $kavlings->where('house_type_id', $type->id);
                    $countLandArea = countLandArea($kavlingByType);
                    $countBuldingArea = countBuildingArea($kavlingByType);
                    $totalHouse += $kavlingByType->count();
                    $totalLand += $countLandArea;
                    $totalBuild += $countBuldingArea;
                @endphp
                <tr>
                    <th>{{ $type->house_type }}</th>
                    <td>{{ $kavlingByType->count() }}</td>
                    <td>{{ $countLandArea }}</td>
                    <td>{{ $countBuldingArea }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Jumlah</th>
                <td>{{ $totalHouse }}</td>
                <td>{{ $totalLand }}</td>
                <td>{{ $totalBuild }}</td>
            </tr>
        </tfoot>
    </table>
    <table>
        <thead>
            <tr>
                <th>Blok</th>
                <th>Nomer Kavling</th>
                <th>Lebar Muka Kavling (M)</th>
                <th>Panjang Kavling (M)</th>
                <th>Panjang Kavling (M)</th>
                <th>Luas Kavling (M<sup>2</sup>)</th>
                <th>Tipe Rumah</th>
                <th>Luas Bangunan (M<sup>2</sup>)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kavlings as $kavling)
                <tr>
                    <th>{{ $kavling->block }}</th>
                    <th>{{ $kavling->number_kavling }}</th>
                    <th>{{ $kavling->width_kavling }}</th>
                    <th>{{ $kavling->length_kavling }}</th>
                    <th>{{ $kavling->length_kavling }}</th>
                    <th>{{ $kavling->area_kavling }}</th>
                    <th>{{ $kavling->houseType->house_type }}</th>
                    <th>{{ $kavling->area_building }}</th>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
