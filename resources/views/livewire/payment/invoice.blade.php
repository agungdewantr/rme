<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <style>
        @page {
            margin: 0px 10px
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0px;
        }

        p {
            font-size: 11pt;
        }

        h4 {
            font-size: 11pt;
        }
    </style>
</head>

<body>
    <div>
        <div>
            <div
                style="width: 30%; float: left; height: 50px; background-image: url({{ public_path('storage/' . $setting->where('field', 'header_logo')->first()->value) }}); background-size: cover; background-repeat: no-repeat; background-position: center center">
                {{-- <img src="{{ public_path('storage/' . $setting->where('field', 'header_logo')->first()->value) }}"
                    alt="wkwk" style="object-fit:cover; margin-right: 10px; width:100%"> --}}
            </div>
            <div style="float: left;">{!! $setting->where('field', 'header_letter')->first()->value !!}
                <p style="margin-top: -20px">{{ $setting->where('field', 'phone_number')->first()->value }} |
                    {{ $setting->where('field', 'email')->first()->value }}</p>
            </div>
            <div style="clear: both;"></div>
        </div>


        <p style="margin-top: -20px;margin-bottom:-25px; text-align: center">
            ==========================================================================================</p>
        <h4 style="text-align: center">*** KWITANSI PEMBAYARAN ***</h4>
        <p style="margin-top: -25px; margin-bottom:-5px; text-align: center">
            ==========================================================================================</p>
        <table width="100%" style="font-size: 10pt">
            <tbody>
                <tr style="width: 100%">
                    <td style="width: 45%">Tgl: <b>{{ $transaction->date }}</b> - No.Kwitansi :
                        <b>{{ $transaction->transaction_number }}</b>
                    </td>
                    <td style="width: 15%"></td>
                    <td style="width: 40%">Kasir: <b>{{ auth()->user()->name }}</b></td>
                </tr>
                <tr>
                    <td style="width: 45%">Waktu Cetak: <b>{{ Carbon\Carbon::now()->format('d-m-Y h:i:s') }}</td>
                    <td style="width: 15%"></td>
                    <td style="width: 40%"></td>
                </tr>
                <tr>
                    <td style="width: 45%">Pasien: <b>{{ $transaction->patient->patient->patient_number }} -
                            {{  ucwords(strtolower($transaction->patient->name)) }}</td>
                    <td style="width: 15%"></td>
                    <td style="width: 40%"></td>
                </tr>
                <tr>
                    <td style="width: 45%">Dokter: <b>{{ $transaction->medicalRecord->doctor->name ?? '-' }}</td>
                    <td style="width: 15%"></td>
                    <td style="width: 40%"></td>
                </tr>
            </tbody>
        </table>
        <p style="margin-top: -5px; margin-bottom: -25px; text-align:center">
            ==========================================================================================</p>
        <h4>Administrasi :</h4>
        <table width="100%" style="margin-top: -20px; font-size:10pt">
            @php
                $total = 0;
            @endphp
            @foreach ($transaction->actions->where('category', 'Administrasi') as $item)
                <tr>
                    <td style="width: 25%">{{ $loop->iteration }}. {{ $item->name }}</td>
                    <td style="width: 25%">{{ number_format($item->price, 2, ',', '.') }} x {{ $item->pivot->qty }}
                    </td>
                    <td style="width: 25%">-{{ $item->pivot->discount }}</td>
                    @php
                        $total_action = $item->price * $item->pivot->qty - $item->pivot->discount;
                        $total += $total_action;
                    @endphp
                    <td style="width: 25%">{{ number_format($total_action, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>
        <p style="text-align: center; margin-top: -8px;margin-bottom: -20px;">
            --------------------------------------------------------------------------------------------------------------------------------------------------------------
        </p>
        <h4>Tindakan :</h4>
        <table width="100%" style="margin-top: -20px; font-size:10pt">
            @foreach ($transaction->actions->where('category', 'Tindakan') as $item)
                <tr>
                    <td style="width: 25%">{{ $item->name }}</td>
                    <td style="width: 25%">{{ number_format($item->price, 2, ',', '.') }} x {{ $item->pivot->qty }}
                    </td>
                    <td style="width: 25%">-{{ $item->pivot->discount }}</td>
                    @php
                        $total_action = $item->price * $item->pivot->qty - $item->pivot->discount;
                        $total += $total_action;
                    @endphp
                    <td style="width: 25%">{{ number_format($total_action, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>
        <p style="text-align: center; margin-top: -8px;margin-bottom: -20px;">
            --------------------------------------------------------------------------------------------------------------------------------------------------------------
        </p>
        <h4>Obat :</h4>
        <table width="100%" style="margin-top: -20px; font-size:10pt">
            @foreach ($transaction->drugMedDevs as $item)
                @php
                    $total_drug = $item->selling_price * $item->pivot->qty - $item->pivot->discount;
                    $total += $total_drug;
                @endphp
                <tr>
                    <td style="width: 25%">{{ $item->name }}</td>
                    <td style="width: 25%">{{ number_format($item->selling_price, 2, ',', '.') }} x
                        {{ $item->pivot->qty }}</td>
                    <td style="width: 25%">-{{ $item->pivot->discount }}</td>
                    <td style="width: 25%">{{ number_format($total_drug, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>
        <p style="text-align: center; margin-top: -8px;margin-bottom: -5px;">
            --------------------------------------------------------------------------------------------------------------------------------------------------------------
        </p>
        <table width="100%" style="font-size:11pt">
            <tr>
                <td width="20%"><b>Jumlah :</b></td>
                <td width="60%"></td>
                <td width="20%"><b>{{ number_format($total, 2, ',', '.') }}</b></td>
            </tr>
            <tr>
                <td width="20%"><b>Total :</b></td>
                <td width="60%"></td>
                <td width="20%"><b>{{ number_format($total, 2, ',', '.') }}</b></td>
            </tr>
            <tr>
                <td width="40%">Pembayaran >
                    {{ $transaction->payment_method == 'Cash' ? 'Tunai' : $transaction->payment_method . ' ' . $transaction->bank }}
                </td>
                <td width="40%"></td>
                <td width="20%">{{ number_format($transaction->payment_amount, 2, ',', '.') }}</td>
            </tr>
            @if ($transaction->payment_method == 'Cash')
                <tr>
                    <td width="20%"><b>Kembalian:</b></td>
                    <td width="60%"></td>
                    <td width="20%">{{ number_format($transaction->payment_amount - $total, 2, ',', '.') }}</td>
                </tr>
            @endif
        </table>
        <p style="margin-top: -5px; margin-bottom: -20px; text-align:center">
            ==========================================================================================</p>
        <p style="text-align: center">Terima Kasih, Semoga Lekas Sembuh</p>
    </div>
</body>

</html>
