<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    @vite('resources/css/app.css')
    <style>
        @media print {
            @page {
            size: A5 landscape;
            margin: 0;
            }
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0px;
        }

        p {
            font-size: 11pt;
        }

        /* h4 {
            font-size: 11pt;
        } */
    </style>
</head>

<body class="tw-max-w-[21cm] tw-mx-auto tw-flex tw-flex-col tw-justify-center tw-items-center">
    <div class="tw-mx-4 tw-mt-6">
        <div class="tw-flex tw-items-center">
            {{-- <div class="tw-w-1/3 tw-h-20 tw-bg-cover tw-bg-no-repeat tw-bg-center" style="background-image: url({{ public_path('storage/' . $setting->where('field', 'header_logo')->first()->value) }});"></div> --}}
            <img src="{{asset('storage/' . $setting->where('field', 'header_logo')->first()->value)}}" style="object-fit: cover; max-width:120px;" alt="" class="tw-mr-4">

            <div class="tw-flex-grow tw-pl-4">
                {!! $setting->where('field', 'header_letter')->first()->value !!}
                <p class="tw-text-sm">{{$branch->address}}</p>
                <p class="tw-text-sm">{{$branch->phone_number}}</p>

            </div>
        </div>

        <p class="tw-text-center tw-text-xs">============================================================================================================</p>
        <h4 class="tw-text-center tw-text-sm" style="margin: -7px 0 -7px 0">*** KWITANSI PEMBAYARAN ***</h4>
        <p class="tw-text-center tw-text-xs">============================================================================================================</p>

        <table class="tw-w-full tw-text-xs tw-my-2" style="margin: -5px 0 -5px 0">
            <tbody>
                <tr>
                    <td class="tw-w-1/2 bg-primary">Tanggal: <b>{{ Carbon\Carbon::parse($transaction->date)->format('d-m-Y') }}</b></td>
                    <td class="tw-w-1/2 tw-text-right bg-success">Waktu Cetak: <b>{{ Carbon\Carbon::now()->format('d-m-Y h:i:s') }}</b></td>
                </tr>
                <tr>
                    <td class="tw-w-1/2 "> Pasien: <b>{{ $transaction->patient->patient->patient_number }} -
                        {{  ucwords(strtolower($transaction->patient->name)) }}</b></td>
                    <td class="tw-w-1/2 tw-text-right">No.Kwitansi :
                        <b>{{ $transaction->transaction_number }}</b>
                    </td>
                </tr>
                <tr>
                    <td class="tw-w-1/2">
                        Dokter: <b>{{ $transaction->medicalRecord->doctor->name ?? '-' }}</b>
                    </td>
                    <td class="tw-w-1/2 tw-text-right">Kasir: <b>{{ auth()->user()->name }}</b></td>
                </tr>
                <tr>

                </tr>
            </tbody>
        </table>

        <p class="tw-text-center tw-text-xs">============================================================================================================</p>
        <h4 class="tw-my-2" style="margin-top:-9px">Administrasi :</h4>
        <table class="tw-w-full tw-text-xs" style="margin-top:-9px">
            @php
                $total = 0;
            @endphp
            @foreach ($transaction->actions->where('category', 'Administrasi') as $item)
                <tr>
                    <td class="tw-w-1/4">{{ $loop->iteration }}. {{ $item->name }}</td>
                    <td class="tw-w-1/4">{{ number_format($item->price, 2, ',', '.') }} x {{ $item->pivot->qty }}</td>
                    <td class="tw-w-1/4">-{{ $item->pivot->discount }}</td>
                    @php
                        $total_action = $item->price * $item->pivot->qty - $item->pivot->discount;
                        $total += $total_action;
                    @endphp
                    <td class="tw-w-1/4">{{ number_format($total_action, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>
        <p class="tw-text-center" style="margin-top:-10px">---------------------------------------------------------------------------------------------------------------------------------------------------------</p>
        <h4  style="margin-top:-9px">Tindakan :</h4>
        <table class="tw-w-full tw-text-xs" style="margin-top:-3px">
            @foreach ($transaction->actions->where('category', 'Tindakan') as $item)
                <tr>
                    <td class="tw-w-1/4">{{ $item->name }}</td>
                    <td class="tw-w-1/4">{{ number_format($item->price, 2, ',', '.') }} x {{ $item->pivot->qty }}</td>
                    <td class="tw-w-1/4">-{{ $item->pivot->discount }}</td>
                    @php
                        $total_action = $item->price * $item->pivot->qty - $item->pivot->discount;
                        $total += $total_action;
                    @endphp
                    <td class="tw-w-1/4">{{ number_format($total_action, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            @foreach ($transaction->laborates as $item)
            <tr>
                <td class="tw-w-1/4">{{ $item->name }}</td>
                <td class="tw-w-1/4">{{ number_format($item->price, 2, ',', '.') }} x {{ $item->pivot->qty }}</td>
                <td class="tw-w-1/4">-{{ $item->pivot->discount }}</td>
                @php
                    $total_action = $item->price * $item->pivot->qty - $item->pivot->discount;
                    $total += $total_action;
                @endphp
                <td class="tw-w-1/4">{{ number_format($total_action, 2, ',', '.') }}</td>
            </tr>
        @endforeach
        </table>
        <p class="tw-text-center" style="margin-top:-10px">----------------------------------------------------------------------------------------------------------------------------------------------------------</p>
        <h4  style="margin-top:-9px">Obat :</h4>
        <table class="tw-w-full tw-text-xs" style="margin-top:-3px">
            @foreach ($transaction->drugMedDevs as $item)
                @php
                    $total_drug = $item->selling_price * $item->pivot->qty - $item->pivot->discount;
                    $total += $total_drug;
                @endphp
                <tr>
                    <td class="tw-w-1/4">{{ $item->name . ' '.$item->pivot->rule ?? '-'  }} {{$item->pivot->how_to_use ? '('.$item->pivot->how_to_use.')' : ''}}</td>
                    <td class="tw-w-1/4">{{ number_format($item->selling_price, 2, ',', '.') }} x {{ $item->pivot->qty }}</td>
                    <td class="tw-w-1/4">-{{ $item->pivot->discount }}</td>
                    <td class="tw-w-1/4">{{ number_format($total_drug, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>
        <p class="tw-text-center" style="margin-top:-10px">----------------------------------------------------------------------------------------------------------------------------------------------------------</p>
        <table class="tw-w-full tw-text-xs">
            <tr>
                <td class="tw-w-1/5"><b>Jumlah :</b></td>
                <td class="tw-w-3/5"></td>
                <td class="tw-w-1/5"><b>{{ number_format($total, 2, ',', '.') }}</b></td>
            </tr>
            <tr>
                <td class="tw-w-1/5"><b>Total :</b></td>
                <td class="tw-w-3/5"></td>
                <td class="tw-w-1/5"><b>{{ number_format($total, 2, ',', '.') }}</b></td>
            </tr>
            <tr>
                <td class="tw-w-1/5"><b>Pembayaran :</b></td>
                <td class="tw-w-3/5"></td>
                <td class="tw-w-1/5"></td>
            </tr>
            @foreach ($transaction->paymentMethods as $pm)
            @if($pm->pivot->amount > 0)
            <tr>
                <td class="tw-w-2/5">
                    &nbsp;&nbsp;{{ $pm->name}} {{$pm->pivot->bank ? '- ('.$pm->pivot->bank .')' : ''}}
                </td>
                <td class="tw-w-2/5"></td>
                <td class="tw-w-1/5">{{ number_format($pm->pivot->amount, 2, ',', '.') }}</td>
            </tr>
            @endif
            @endforeach
            @if(($transaction->paymentMethods->reduce(fn($a,$b) => $a+$b->pivot->amount) - $total) > 0)
            <tr>
                <td class="tw-w-1/5"><b>Kembalian :</b></td>
                <td class="tw-w-3/5"></td>
                <td class="tw-w-1/5">{{ number_format(($transaction->paymentMethods->reduce(fn($a,$b) => $a+$b->pivot->amount)- $total), 2, ',', '.') }}</td>
            </tr>
            @endif

        </table>
        <p class="tw-text-center tw-text-xs" style="margin-top:-8px">============================================================================================================</p>
        <p class="tw-text-center tw-text-xs" style="margin-top:-5px">Terima Kasih, Semoga Sehat Selalu</p>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
        window.print()
        });
        window.onafterprint = function() {
            window.close();
        };
        window.onbeforeprint = function() {
            window.addEventListener('afterprint', function() {
                window.close();
            }, { once: true });
        };
        window.onblur = function() {
            window.close();
        };
    </script>
</body>

</html>
