<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Dokter</title>
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
    <p class="tw-text-lg tw-font-bold">Laporan Jasa Medis Dokter (Laporan Harian)</p>

    @if($dateRange)
    Tanggal : {{Carbon\Carbon::parse($dateRange[0])->format('d-m-Y') .' - '.Carbon\Carbon::parse($dateRange[1])->format('d-m-Y')}} <br>
    @endif
    @if($doctorFiltered)
    <span class="!tw-justify-start !tw-items-start tw-font-bold"> {{$doctorFiltered->healthWorker->name}}</span>
    {{'No. SIP '.$doctorFiltered->healthWorker->practice_license ?? '-'}}
    @endif
    <table class="tw-table-auto tw-w-full tw-border-collapse tw-border tw-border-gray-400 tw-bg-white tw-mb-4">
        <thead>
            <tr>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">No</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Tanggal</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Dokter</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Cabang</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Poli</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Tindakan</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Harga (Rp)</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Jumlah</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($table as $item)
                <tr>
                    <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">{{$i++}}</td>
                    <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">{{$item['date']}}</td>
                    <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">{{$item['doctor']}}</td>
                    <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">{{$item['branch']}}</td>
                    <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">{{$item['poli']}}</td>
                    <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">{{$item['name']}}</td>
                    <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp. {{number_format($item['price'], 0, '.', '.')}}</td>
                    <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">{{ $item['qty'] }}</td>
                    <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp. {{number_format($item['total'])}}</td>
                </tr>
            @endforeach
            @if ($table->sum('total') > 0)
                <tr>
                    <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300 tw-font-bold tw-text-right" colspan="8">Grand Total</td>
                    <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300 tw-font-bold">Rp. {{number_format(($table->sum('total') ?? 0), 0, '.', '.')}}</td>
                </tr>
            @endif
        </tbody>
    </table>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
    integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @if($isDownload)
        <script>
            document.addEventListener("DOMContentLoaded", function(event) {
                var element = document.body
                var opt = {
                    margin: 0,
                    filename: 'Laporan-dokter.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 1
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
