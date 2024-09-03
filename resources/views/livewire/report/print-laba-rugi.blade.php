<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Laba Rugi</title>
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
    <p class="tw-text-lg tw-font-bold">Laporan Laba Rugi</p>

    @if($date)
    Tanggal : {{Carbon\Carbon::parse($date[0])->addDay()->format('d-m-Y') .' - '.Carbon\Carbon::parse($date[1])->addDay()->format('d-m-Y')}} <br>
    @endif
    <table class="tw-table-auto tw-w-full tw-border-collapse tw-border tw-border-gray-400 tw-bg-white tw-mb-4">
        <thead>
            <tr>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">ID</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Nama Akun</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Nominal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td  class="tw-px-4 tw-py-2 tw-border tw-border-gray-300"></td>
                <td  class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Pendapatan</td>
                <td  class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp. {{number_format(($income_action ?? 0), 0, '.', '.')}}</td>
            </tr>
            <tr>
                <td  class="tw-px-4 tw-py-2 tw-border tw-border-gray-300"></td>
                <td  class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Penjualan Obat</td>
                <td  class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp. {{number_format(($income_drug ?? 0), 0, '.', '.')}}</td>
            </tr>
            <tr>
                <td colspan="2" class="tw-text-right tw-font-bold tw-px-4 tw-py-2 tw-border tw-border-gray-300">Total Pendapatan</td>
                <td class="tw-font-bold tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp. {{number_format(($income_action + $income_drug ?? 0), 0, '.', '.')}}</td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td  class="tw-px-4 tw-py-2 tw-border tw-border-gray-300"></td>
                <td  class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Pembelian Obat</td>
                <td  class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp. {{number_format(($outcome_drug ?? 0), 0, '.', '.')}}</td>
            </tr>
            @foreach ($outcome as $item)
                <tr>
                    <td  class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">{{!isset(explode('-', $item->name)[1]) ? '-' : explode('-', $item->name)[0]}}</td>
                    <td  class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">{{!isset(explode('-', $item->name)[1]) ? $item->name  : explode('-', $item->name)[1]}}</td>
                    <td  class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp. {{number_format(($item->total ?? 0), 0, '.', '.')}}</td>
                </tr>
            @endforeach
            <td colspan="2" class="tw-text-right tw-font-bold text-primary tw-px-4 tw-py-2 tw-border tw-border-gray-300">Laba / Rugi</td>
            <td class="tw-font-bold text-primary tw-px-4 tw-py-2 tw-border tw-border-gray-300">Rp. {{number_format((($income_action + $income_drug) - ($outcome_drug+$outcome->sum('total')) ?? 0), 0, '.', '.')}}</td>
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
                    filename: 'Laporan-laba-rugi-.pdf',
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
