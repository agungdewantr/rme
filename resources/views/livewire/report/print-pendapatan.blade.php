<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>laporan Pendapatan</title>

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
<body class="tw-max-w-full tw-mx-auto tw-flex tw-flex-col tw-justify-center tw-items-center">
    <p class="tw-text-lg tw-font-bold">Laporan pendapatan</p>
    <table class="tw-table-auto tw-w-full tw-border-collapse tw-border tw-border-gray-400 tw-bg-white tw-mb-4">
        <thead>
            <tr>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">No</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Tanggal</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Cabang</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Tindakan</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Laborate</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Obat</th>
                {{-- <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Obat Langsung</th> --}}
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Pembayaran Tunai</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Pembayaran EDC</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Pembayaran Transfer</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Pembayaran QRIS</th>
                {{-- <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Uang Tunai Akumulatif</th> --}}
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Pendapatan Harian</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grand_total = 0;
                $sum_action = 0;
                $sum_laborate = 0;
                $sum_drug = 0;
                $sum_cash = 0;
                $sum_edc = 0;
                $sum_transfer = 0;
                $sum_harian = 0;
                $sum_qris = 0;
            @endphp
            @foreach ($results as $item)
            <tr>
                <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">{{$loop->iteration}}</td>
                <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">{{$item->date}}</td>
                <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">{{$item->branch}}</td>
                <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp. {{ number_format($item->total_action, 0, '.', '.')}}</td>
                <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp. {{ number_format($item->total_laborate, 0, '.', '.')}}</td>
                <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp. {{ number_format($item->total_drug, 0, '.', '.')}}</td>
                {{-- <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp. {{ number_format($item->total_ds, 0, '.', '.')}}</td> --}}
                <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp. {{ number_format($item->total_cash, 0, '.', '.')}}</td>
                <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp. {{ number_format($item->total_edc, 0, '.', '.')}}</td>
                <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp. {{ number_format($item->total_transfer, 0, '.', '.')}}</td>
                <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp. {{ number_format($item->total_qris, 0, '.', '.')}}</td>
                {{-- <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp. {{ number_format($item->accumulativeCash, 0, '.', '.')}}</td> --}}
                <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp. {{ number_format($item->total_cash+$item->total_edc+$item->total_transfer+$item->total_qris, 0, '.', '.')}}</td>
            </tr>
            @php
                $grand_total += $item->total_cash + $item->total_edc + $item->total_transfer + $item->total_qris;
                $sum_action += $item->total_action;
                $sum_laborate += $item->total_laborate;
                $sum_drug += $item->total_drug;
                $sum_cash += $item->total_cash;
                $sum_edc += $item->total_edc;
                $sum_harian += $item->total_cash - $item->total_outcome_cash;
                $sum_transfer += $item->total_transfer;
                $sum_qris += $item->total_qris;
            @endphp
            @endforeach

            <tr>
                <td colspan="3" class="tw-px-4 tw-py-2 tw-border tw-border-gray-300 tw-text-end">Grand Total</td>
                <td>Rp. {{number_format(($sum_action ?? 0), 0, '.', '.')}}</td>
                <td>Rp. {{number_format(($sum_laborate ?? 0), 0, '.', '.')}}</td>
                <td>Rp. {{number_format(($sum_drug ?? 0), 0, '.', '.')}}</td>
                <td>Rp. {{number_format(($sum_cash ?? 0), 0, '.', '.')}}</td>
                <td>Rp. {{number_format(($sum_edc ?? 0), 0, '.', '.')}}</td>
                <td>Rp. {{number_format(($sum_transfer ?? 0), 0, '.', '.')}}</td>
                <td>Rp. {{number_format(($sum_qris ?? 0), 0, '.', '.')}}</td>
                {{-- <td>Rp. {{number_format(($reports[0]->accumulativeCash ?? 0), 0, '.', '.')}}</td> --}}
                <td>Rp. {{number_format(($grand_total ?? 0), 0, '.', '.')}}</td>
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
                    filename: 'Laporan-pendapatan.pdf',
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
