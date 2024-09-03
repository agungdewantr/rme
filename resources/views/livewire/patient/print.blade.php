<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Asesmen Awal</title>
    @vite('resources/css/app.css')
    <style>
        @media print {
            /* Mengatur ukuran kertas menjadi A4 */
            @page {
                size: A4;
            }
        }
    </style>
</head>
<body class="tw-max-w-[21cm] tw-justify-center tw-items-center">
    <img src="{{ asset('assets/img/bm-long.jpg') }}" class="" alt="" class=""><br>
    <div class="tw-flex tw-flex-row">
        <div class="tw-flex-1">
            <table>
                <tr>
                    <td class="tw-font-bold">Nama Ibu</td>
                    <td>: {{$patient->name}}</td>
                </tr>
                <tr>
                    <td class="tw-font-bold">Tanggal Lahir / Usia</td>
                    <td>: {{ $patient->dob ? Carbon\Carbon::parse($patient->dob)->format('d-m-Y') . ' ('. $age_patient->format('%y tahun %m bulan') .')' : '-'}}</td>
                </tr>
                <tr>
                    <td class="tw-font-bold">Alamat</td>
                    <td>: {{$patient->address . ', '. $patient->city }}</td>
                </tr>
                <tr>
                    <td class="tw-font-bold">Pekerjaan</td>
                    <td>: {{$patient->job->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="tw-font-bold">No Telepon</td>
                    <td>: {{$patient->phone_number }}</td>
                </tr>
                <tr>
                    <td class="tw-font-bold">Riwayat Perkawinan</td>
                    <td>: {{$patient->status_pernikahan }}</td>
                </tr>
            </table>
        </div>
        <div class="tw-flex-1" style="margin-left: auto;">
            @if($patient->status_pernikahan == 'Menikah')
            <table>
                <tr>
                    <td class="tw-font-bold">Nama Suami</td>
                    <td>: {{$patient->husbands_name}}</td>
                </tr>
                <tr>
                    <td class="tw-font-bold">Tanggal Lahir / Usia</td>
                    <td>: {{ $patient->husbands_birth_date ? $age_husband->format('%y tahun')  : '-'}} </td>
                </tr>
                <tr>
                    <td class="tw-font-bold">Alamat</td>
                    <td>: {{$patient->husbands_address }}</td>
                </tr>
                <tr>
                    <td class="tw-font-bold">Pekerjaan</td>
                    <td>: {{$patient->husbands_job ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="tw-font-bold">No Telepon</td>
                    <td>: {{$patient->husbands_phone_number }}</td>
                </tr>
            </table>
            @endif
        </div>
    </div>
    <div class="tw-border-2 tw-mt-2 tw-py-3 tw-px-3 tw-rounded-lg tw-border-sky-500">
        <div class="tw-grid tw-grid-cols-4 tw-gap-4">
            <div class="tw-col-span-3 ...">
                <p class="tw-font-bold">Riwayat Kehamilan</p>
                <table class="tw-border-collapse tw-border tw-border-slate-500">
                    <thead>
                        <tr>
                            <th class="tw-border tw-border-slate-600" width=8%>Hamil ke-</th>
                            <th class="tw-border tw-border-slate-600">Persalinan</th>
                            <th class="tw-border tw-border-slate-600" width="160">Jenis Kelamin</th>
                            <th class="tw-border tw-border-slate-600" width="13%">BB Lahir</th>
                            <th class="tw-border tw-border-slate-600" width="160">Usia Anak</th>
                            <th class="tw-border tw-border-slate-600">Ket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $gender = ['Perempuan', 'Laki-Laki', 'Keguguran', 'Hamil INI'];
                        @endphp
                        @forelse ($patient->obstetri as $o)
                            <tr>
                                <td class="tw-border tw-border-slate-600">{{ $loop->iteration }}</td>
                                <td class="tw-border tw-border-slate-600">{{ $o->type_of_birth }}</td>
                                <td class="tw-border tw-border-slate-600">{{ is_null($o->gender) ? '-' : ($o->gender == 1 ? 'Laki-laki' : ($o->gender == 0 ? 'Perempuan' : ($o->gender == 2 ? 'Keguguran' : ($o->gender == 3 ? 'Hamil INI' : '-')))) }}
                                </td>
                                <td class="tw-border tw-border-slate-600">{{ $o->weight ?? 0 }} gr</td>
                                <td class="tw-border tw-border-slate-600">{{$o->age ?? 0}} tahun</td>
                                </td>
                                <td class="tw-border tw-border-slate-600">{{ $o->clinical_information }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" align="center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="...">
                <table>
                    <tr>
                        <td class="tw-font-bold">HPHT</td>
                        <td>: {{isset($patient->firstEntry[0]->hpht) ? Carbon\Carbon::parse($patient->firstEntry[0]->hpht)->format('d-m-Y') : '-'}}</td>
                    </tr>
                    <tr>
                        <td class="tw-font-bold">TP</td>
                        <td>: {{isset($patient->firstEntry[0]->hpht)  ? Carbon\Carbon::parse($patient->firstEntry[0]->edd)->format('d-m-Y') : '-'}}</td>
                    </tr>
                    <tr>
                        <td class="tw-font-bold">TB</td>
                        <td>: {{isset($patient->firstEntry[0]->height) > 0 ? $patient->firstEntry[0]->height.' cm' : '-'}}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="tw-grid tw-mt-6 tw-grid-cols-3 tw-gap-4">
            <div class="...">
                <p class="tw-font-bold">Riwayat Penyakit Terdahulu</p>
                @foreach ($patient->illnessHistories as $key => $i)
                    {{{$key+1 . '. ' .$i->name .' / ' . $i->pivot->therapy}}}
                @endforeach
                @if($patient->illnessHistories->count() == 0)
                {{'-'}}
                @endif
            </div>
            <div class="...">
                <p class="tw-font-bold">Riwayat Penyakit Keluarga</p>
                @foreach ($patient->familyIlnessHistories as $key => $i)
                {{{$key+1 . '. ' .$i->name .' ('.$i->relationship.') / '.$i->disease_name}}}
                @endforeach
                @if($patient->familyIlnessHistories->count() == 0)
                {{'-'}}
                @endif
            </div>
            <div class="...">
                <p class="tw-font-bold">Riwayat Alergi</p>
                @foreach ($patient->allergyHistories as $key => $i)
                {{{$key+1 . '. ' .$i->name}}}
                @endforeach
                @if($patient->allergyHistories->count() == 0)
                {{'-'}}
                @endif
            </div>
        </div>
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
