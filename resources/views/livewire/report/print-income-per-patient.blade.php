<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pendapatan Per Pasien</title>
    @vite('resources/css/app.css')
    <style>
        @media print {

            /* Mengatur ukuran kertas menjadi A4 */
            @page {
                size: A4 landscape;
                margin: 0;
            }
        }

        body {
            padding: 2cm;
            box-sizing: border-box;
        }
    </style>
</head>

<body class="tw-max-w-[29.7cm] tw-mx-auto tw-flex tw-flex-col tw-justify-center tw-items-center">
    <p class="tw-text-lg tw-font-bold">Laporan &nbsp; Pendapatan &nbsp; Per&nbsp;Pasien</p>
    <table class="tw-table-auto tw-w-full tw-border-collapse tw-border tw-border-gray-400 tw-bg-white tw-mb-4">
        <thead>
            <tr>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Tanggal</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Pasien</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Dokter</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Poli</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Tindakan</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Obat</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Disc (Rp)</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Total</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Pendapatan</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $t)
                <tr>
                    <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">
                        {{ \Carbon\Carbon::parse($t->date)->format('d-m-Y') }}</td>
                    <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">{{ ucwords(strtolower($t->patient->name)) }}
                    </td>
                    <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">
                        {{ ucwords(strtolower($t->doctor?->name)) ?? '-'}}</td>
                    <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">
                        {{ $t->medicalRecord->registration->poli ?? '-' }}</td>
                    <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">
                        @foreach ($t->actions as $a)
                            <p class="tw-m-0">{{ $a->name }}</p>
                        @endforeach
                    </td>
                    <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">
                        @foreach ($t->drugMedDevs as $d)
                            <p class="tw-m-0">{{ $d->name }}</p>
                        @endforeach
                    <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">
                        Rp{{ number_format($t->actions->reduce(fn($e, $f) => $e + ($f->pivot->discount ?? 0)) +
                                        $t->drugMedDevs->reduce(fn($e, $f) => $e + ($f->pivot->discount ?? 0)) +
                                        $t->laborates->reduce(fn($e, $f) => $e + ($f->pivot->discount ?? 0)), 0, '.', '.') }}
                    </td>
                    <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">
                        Rp{{ number_format(
                                    $t->actions->reduce(fn($e, $f) => $e + ($f->pivot->qty ?? 0) * ($f->price ?? 0)) +
                                        $t->drugMedDevs->reduce(fn($e, $f) => $e + ($f->pivot->qty ?? 0) * ($f->selling_price ?? 0)) +
                                        $t->laborates->reduce(fn($e, $f) => $e + ($f->pivot->qty ?? 0) * ($f->price ?? 0)),
                                    0,
                                    '.',
                                    '.',
                                ) }}
                    </td>
                    <td  class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp{{ number_format(
                        ($t->actions->reduce(fn($e, $f) => $e + ($f->pivot->qty ?? 0) * ($f->price ?? 0)) +
                            $t->drugMedDevs->reduce(fn($e, $f) => $e + ($f->pivot->qty ?? 0) * ($f->selling_price ?? 0)) +
                            $t->laborates->reduce(fn($e, $f) => $e + ($f->pivot->qty ?? 0) * ($f->price ?? 0))) -
                            ($t->actions->reduce(fn($e, $f) => $e + ($f->pivot->discount ?? 0)) +
                            $t->drugMedDevs->reduce(fn($e, $f) => $e + ($f->pivot->discount ?? 0)) +
                            $t->laborates->reduce(fn($e, $f) => $e + ($f->pivot->discount ?? 0))),
                        0,
                        '.',
                        '.',
                    ) }}
                    </td>
                </tr>
                @if ($loop->iteration == $transactions->count())
                <tr>
                    <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300" colspan="6" align="right">Grand Total</td>
                    <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp{{ number_format($transactions->reduce(fn($e, $f) => $e + ($f->actions->reduce(fn($e, $f) => $e + ($f->pivot->discount ?? 0)) +
                    $f->drugMedDevs->reduce(fn($e, $f) => $e + ($f->pivot->discount ?? 0))) + $f->laborates->reduce(fn($e, $f) => $e + ($f->pivot->discount ?? 0)))
                    , 0, '.', '.') }}
                    </td>
                    <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp{{ number_format($transactions->reduce(fn($e, $f) => $e + ($f->actions->reduce(fn($e, $f) => $e + ($f->pivot->qty ?? 0) * ($f->price ?? 0)) + $f->drugMedDevs->reduce(fn($e, $f) => $e + ($f->pivot->qty ?? 0) * ($f->selling_price ?? 0)) + $f->laborates->reduce(fn($e, $f) => $e + ($f->pivot->qty ?? 0) * ($f->price ?? 0)))), 0, '.', '.') }}
                    </td>
                    <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp{{ number_format(($transactions->reduce(fn($e, $f) => $e + ($f->actions->reduce(fn($e, $f) => $e + ($f->pivot->qty ?? 0) * ($f->price ?? 0)) + $f->drugMedDevs->reduce(fn($e, $f) => $e + ($f->pivot->qty ?? 0) * ($f->selling_price ?? 0)) + $f->laborates->reduce(fn($e, $f) => $e + ($f->pivot->qty ?? 0) * ($f->price ?? 0))))) -
                    ($transactions->reduce(fn($e, $f) => $e + ($f->actions->reduce(fn($e, $f) => $e + ($f->pivot->discount ?? 0)) +
                    $f->drugMedDevs->reduce(fn($e, $f) => $e + ($f->pivot->discount ?? 0))) + $f->laborates->reduce(fn($e, $f) => $e + ($f->pivot->discount ?? 0)))), 0, '.', '.') }}
                    </td>

                </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @if ($isDownload)
        <script>
            document.addEventListener("DOMContentLoaded", function(event) {
                var element = document.body
                var opt = {
                    margin: 0,
                    filename: 'Laporan Per pasien.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 1
                    },
                    jsPDF: {
                        unit: 'in',
                        format: 'a4',
                        orientation: 'landscape'
                    }
                };

                html2pdf().set(opt).from(element).save();
            })
            window.onblur = function() {
                window.close();
            };
        </script>
    @else
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
                }, {
                    once: true
                });
            };
            window.onblur = function() {
                window.close();
            };
        </script>
    @endif

</body>

</html>
