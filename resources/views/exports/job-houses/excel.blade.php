@php
use Carbon\Carbon;

function convertDate($date)
{
    $result = Carbon::createFromFormat('Y-m-d H:i:s', $date)->isoFormat('D MMMM Y');
    return $result;
}

function checkStatus($start, $end)
{
    $time = Carbon::now();
    if ($time->between($start, $end)) {
        return 'Sedang Dikerjakan';
    } elseif (date('Y-m-d H:i:s') > $end) {
        return 'Selesai Dikerjakan';
    } else {
        return 'Belum Dikerjakan';
    }
}

@endphp

@extends('exports.template')

@section('content')
    <table style="font-family: sans-serif">
        <thead style="text-transform: uppercase;">
            <tr>
                <th>No.</th>
                <th>Nama PIC / Perusahaan</th>
                @if (Request::segment(2) != 'job-other')
                    <th>Customer</th>
                @endif
                <th>Tanggal Pengerjaan</th>
                <th>Total Biaya</th>
                <th>Pembayaran</th>
                <th>Status Pengerjaan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($wholeJobs as $job)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>
                        {{ $job->contractor->pic_name }}
                        <br>
                        {{ $job->contractor->company_name }}
                    </td>
                    @if (Request::segment(2) != 'job-other')
                        <td>
                            {{ $job->customer->name }}
                            <br>
                            Tipe Rumah : {{ $job->houseType->house_type }}
                        </td>
                    @endif
                    <td>{{ convertDate($job->start_date) . ' - ' . convertDate($job->end_date) }}</td>
                    <td>Rp. {{ number_format($job->total_cost, 0, ',', '.') }}</td>
                    <td>{{ $job->payment_type }}</td>
                    <td>{{ checkStatus($job->start_date, $job->end_date) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
