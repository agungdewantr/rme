<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Stock Ledger</title>
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
    <p class="tw-text-lg tw-font-bold">Laporan &nbsp; Stock &nbsp; Ledger</p>
    <table class="tw-table-auto tw-w-full tw-border-collapse tw-border tw-border-gray-400 tw-bg-white tw-mb-4">
        <thead>
            <tr>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Barang</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Satuan</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Stok Masuk</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Stok Keluar</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Stok Akhir</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Cabang</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Avg Value</th>
                <th class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">Balance Value</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($result as $r)
                @foreach ($r as $s)
                    <tr>
                        <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">{{ $s[0]->item->name }}</td>
                        <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">{{ $s[0]->item->uom }}
                        </td>
                        <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">
                            {{ $s->reduce(fn($a, $b) => $a + ($b->in ?? 0)) }}</td>
                        <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">
                            {{ $s->reduce(fn($a, $b) => $a + ($b->out ?? 0)) }}</td>
                        <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">
                            {{ $s->reduce(fn($a, $b) => $a + ($b->in ?? 0)) - $s->reduce(fn($a, $b) => $a + ($b->out ?? 0)) }}
                        </td>
                        <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">
                            {{ $s[0]->batch->stockEntry->branch->name }}</td>
                        <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">{{ $s->avg('batch.new_price') }}</td>
                        <td class="tw-px-4 tw-py-2 tw-border tw-border-gray-300">
                            {{ ($s->reduce(fn($a, $b) => $a + ($b->in ?? 0)) - $s->reduce(fn($a, $b) => $a + ($b->out ?? 0))) * $s->avg('batch.new_price') }}
                        </td>
                    </tr>
                @endforeach
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
                    filename: 'myfile.pdf',
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
