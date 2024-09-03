<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>laporan Pengeluaran</title>

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
            padding: 10px;
            box-sizing: border-box;
        }
    </style>
</head>
<body class="tw-max-w-[29.7cm] tw-mx-auto tw-flex tw-flex-col tw-justify-center tw-items-center">
    <p class="tw-text-lg tw-font-bold">Laporan Pengeluaran</p>
    @if($date)
    Tanggal : {{Carbon\Carbon::parse($date[0])->addDay()->format('d-m-Y') .' - '.Carbon\Carbon::parse($date[1])->addDay()->format('d-m-Y')}} <br>
    @endif
    @if($branch)
    <span class="!tw-justify-start !tw-items-start tw-font-bold"> {{'Cabang: '.$branch}}</span>
    @endif
    <table class="tw-table-auto tw-w-full tw-border-collapse tw-border tw-border-gray-400 tw-bg-white tw-mb-4">
        <thead>
            <tr>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Tanggal</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Cabang</th>
                @php
                foreach ($categoryOutcomes as $c){
                    echo '<th  class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">'.$c->name.'</th>';
                    ${'total' . $c->id} = 0;
                }
                @endphp
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Total Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            @php
            $total = 0;
        @endphp
            @foreach($outcome as $item)
            @php

            $total += $item->total_nominal;
            @endphp
            <tr>
                <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">{{$loop->iteration}}</td>
                <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">{{$item->branch_name}}</td>
                @php
                    foreach ($categoryOutcomes as $c) {
                        $columnName = str_replace([' ', '&', '@', '#', '$', '%', '^', '*', '(', ')'], '_', strtolower($c->name)) . '_total';
                        echo '<td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp. '.number_format($item->$columnName,0,'.','.') .'</td>';
                        ${'total' . $c->id} += $item->$columnName;
                    }
                @endphp
                <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp. {{ number_format($item->total_nominal, 0, '.', '.')}}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="2" class="text-end fw-bold">Grand Total</td>
                @php
                foreach ($categoryOutcomes as $c) {
                    echo '<td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp.' . number_format(${'total' . $c->id} ?? 0, 0, '.', '.') . '</td>';
                }
                @endphp
                <td  class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp. {{ number_format($total, 0, '.', '.') }}</td>
            </tr>
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
                    filename: 'Laporan-pengeluaran.pdf',
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
