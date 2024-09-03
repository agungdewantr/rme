<x-slot:title>
    Detail Pembayaran
</x-slot:title>

<x-page-layout>
    <div>
        <x-slot:breadcrumbs>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" wire:navigate>Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('payment.index') }}" wire:navigate>Pembayaran</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Pembayaran</li>
        </x-slot:breadcrumbs>

        <x-slot:button>
            @if (!$transaction->reference_number)
                <a href="{{ route('payment.invoice', $transaction->uuid) }}"
                    onclick="var a = window.open(this.href) ; a.print(); return false"
                    class="text-decoration-none btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="bottom"
                    data-bs-title="Cetak">
                    <i class="fa-solid fa-print fa-fw"></i>
                </a>
            @endif
        </x-slot:button>

        <div class="card mb-3">
            <div class="card-body">
                @if (!$transaction->reference_number)
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Nomor Invoice</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $transaction->transaction_number }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="date" class="form-label">Tanggal</label>
                                <div wire:ignore class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fa-solid fa-calendar-days"></i>
                                    </span>
                                    <input type="text" name="date" class="form-control" disabled
                                        value="{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Lihat Medical History
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Medical History
                                                    </h1>
                                                    <p class="m-0">Sudah {{ $medicalRecords->count() }} kali
                                                        pemeriksaan
                                                    </p>
                                                </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="p-2">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Dokter<br>Tanggal<br>Dokter/Perawat</th>
                                                                <th>Rekam Medis</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($medicalRecords as $mr)
                                                                <tr>
                                                                    <td>
                                                                        <p>Cabang :
                                                                            {{ $mr->registration->branch->name }} </p>
                                                                        <p>{{ \Carbon\Carbon::parse($mr->date)->format('d/m/Y') }}
                                                                        </p>
                                                                        <p>Dokter : {{ $mr->doctor?->name }}</p>
                                                                    </td>
                                                                    <td>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <p class="fw-bold">Subjective:</p><br>
                                                                                <p>{{ $mr->subjective_summary }}</p>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <p class="fw-bold">Objective:</p><br>
                                                                                <p>{{ $mr->objective_summary }}</p>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <p class="fw-bold">Asesmen:</p>
                                                                                <p>{{ $mr->assessment_summary ?? '-' }}
                                                                                </p>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <p>
                                                                                    <span
                                                                                        class="fw-bold">EDD:</span>{{ $mr->edd ? \Carbon\Carbon::parse($mr->edd)->format('d/m/Y') : '' }}
                                                                                </p>
                                                                                <p class="fw-bold">Hasil Lab
                                                                                    Lainnya:</p>
                                                                                <p>{{ $mr->other_lab }}</p>
                                                                                <p class="fw-bold">Resep
                                                                                    Luar:</p>
                                                                                <p>{{ $mr->other_recipe }}
                                                                                </p>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <p>Plan:</p>
                                                                                <p>{{ $mr->other_summary ?? '-' }}</p>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="d-flex align-items-start">
                                                                                    @foreach ($mr->usgs as $u)
                                                                                        <a href="{{ asset('storage/' . $u->file) }}"
                                                                                            class="btn btn-primary btn-sm"
                                                                                            noreferer noopener
                                                                                            target="_blank">Lihat
                                                                                            File</a>
                                                                                    @endforeach

                                                                                    {{-- <p>Hasil USG:</p>

                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <p>FL:{{ $mr->fl }}</p>
                                                                                        <p>FHR:{{ $mr->fhr }}</p>
                                                                                        <p>EFW:{{ $mr->efw }}</p>
                                                                                        <p>AC:{{ $mr->ac }}</p>
                                                                                        <p>GA:{{ $mr->ga }}</p>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <p>GS:{{ $mr->gs }}</p>
                                                                                        <p>CRL:{{ $mr->crl }}</p>
                                                                                        <p>BPD:{{ $mr->bpd }}</p>

                                                                                    </div>
                                                                                </div> --}}
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="row">
                                                                                    <div class="col-md-3">
                                                                                        <div>
                                                                                            <span
                                                                                                class="text-primary">Obat
                                                                                                :</span> <br>
                                                                                            @foreach ($mr->drugMedDevs as $a)
                                                                                                {{ '- ' . $a->name }}
                                                                                                <br>
                                                                                            @endforeach
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div>
                                                                                            <span
                                                                                                class="text-primary">Tindakan
                                                                                                :</span> <br>
                                                                                            @foreach ($mr->actions as $a)
                                                                                                {{ '- ' . $a->name }}
                                                                                                <br>
                                                                                            @endforeach
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div>
                                                                                            <span
                                                                                                class="text-primary">Laborate
                                                                                                :</span> <br>
                                                                                            @foreach ($mr->laborate as $a)
                                                                                                {{ '- ' . $a->name }}
                                                                                                <br>
                                                                                            @endforeach
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <p>{{ \Carbon\Carbon::parse($mr->date)->format('d/m/Y') }}
                                                                        </p>
                                                                        <p>Perawat : {{ $mr->nurse?->name }}</p>
                                                                    </td>
                                                                    <td>
                                                                        <div class="row">
                                                                            @if ($mr->date_lab != null)
                                                                                <p>Hasil lab:</p>

                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <p>Goldar:{{ $mr->blood_type }}
                                                                                        </p>
                                                                                        <p>Hemoglobin
                                                                                            Umum:{{ $mr->hemoglobin }}
                                                                                        </p>
                                                                                        <p>HIV:{{ $mr->hiv }}</p>
                                                                                        <p>Reduksi
                                                                                            Urine:{{ $mr->urine_reduction }}
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <p>Gula Darah
                                                                                            Acak:{{ $mr->random_blood_sugar }}
                                                                                        </p>
                                                                                        <p>HBSAG:{{ $mr->hbsag }}
                                                                                        </p>
                                                                                        <p>Syphilis:{{ $mr->syphilis }}
                                                                                        </p>
                                                                                        <p>Protein
                                                                                            Urine:{{ $mr->urine_protein }}
                                                                                    </div>
                                                                                    </p>
                                                                                </div>
                                                                            @endif
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <p>Asesmen :</p>

                                                                                    <p>{{ $mr->diagnose }}
                                                                                    </p>
                                                                                    <p>{{ $mr->summary }}
                                                                                    </p>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <p class="fw-bold">Hasil
                                                                                        Lab
                                                                                        Lainnya:</p>
                                                                                    <p>{{ $mr->other_lab }}
                                                                                    </p>
                                                                                    <p class="fw-bold">Resep
                                                                                        Luar:</p>
                                                                                    <p>{{ $mr->other_recipe }}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <p> Plan :</p>
                                                                                <p>{{ $mr->plan_note }}</p>
                                                                            </div>
                                                                            <div class="row">
                                                                                <p>Perhatian Khusus :</p>
                                                                                <p>{{ $mr->firstEntry->specific_attention ?? '-' }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="2">
                                                                        Tidak Ada
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="medical_record_number" class="form-label">Nomor Rekam Medis</label>
                                <input type="text" class="form-control" id="medical_record_number" disabled
                                    value="{{ $transaction->medicalRecord?->medical_record_number }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="doctor" class="form-label">Dokter</label>
                                <input type="text" class="form-control" id="doctor" disabled
                                    value="{{ $transaction->doctor?->name }}">
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="user_id" class="form-label">Pasien</label>
                                <input type="text" class="form-control" id="user_id" disabled
                                    value="{{ ucwords(strtolower($transaction->patient->name)) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="nik" class="form-label">NIK Pasien</label>
                                <input type="text" class="form-control" id="nik"
                                    value="{{ $transaction->patient->patient->nik ?? '-' }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="nik" class="form-label">Poli</label>
                                <input type="text" class="form-control" id="nik"
                                    value="{{ $transaction->poli->name ?? '-' }}" disabled>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Nomor Invoice</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $transaction->transaction_number }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="date" class="form-label">Tanggal</label>
                                <div wire:ignore class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fa-solid fa-calendar-days"></i>
                                    </span>
                                    <input type="text" name="date" class="form-control" disabled
                                        value="{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="user_id" class="form-label">Penerima</label>
                                <input type="text" class="form-control" id="user_id" disabled
                                    value="{{ $stockTransfer ? ucwords(strtolower($stockTransfer->receiver->name)) : '-' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('stock-transfer.show', $stockTransfer->uuid) }}" target="_blank"
                                class="tw-cursor-pointer">
                                <span class="form-label">Stock Transfer Number</span> </a>
                            <input type="text" class="form-control" id="user_id" disabled
                                value="{{ $stockTransfer ? $stockTransfer->stock_transfer_number : '-' }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="user_id" class="form-label">Grand Total</label>
                                <input type="text" class="form-control" id="user_id" disabled
                                    value="Rp {{ $stockTransfer ? number_format($stockTransfer->amount, 0, '.', '.') : '-' }}">
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @if (!$transaction->reference_number)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="h6">Obat, Tindakan dan Laborate</p>

                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Tipe</th>
                                    <th>Aturan Pakai</th>
                                    <th>Cara Pakai</th>
                                    <th>Harga</th>
                                    <th>Diskon</th>
                                    <th>Promo</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($transaction->actions as $key => $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td style="width:250px">
                                            {{ $item->name }}
                                        </td>
                                        <td>
                                            {{ $item->pivot->qty }}
                                        </td>
                                        <td style="vertical-align: middle">-</td>
                                        <td style="vertical-align: middle">-</td>
                                        <td style="vertical-align: middle">{{ $item->type ?? '-' }}</td>
                                        <td style="vertical-align: middle">{{ $item->rule ?? '-' }}</td>
                                        <td style="vertical-align: middle">
                                            Rp{{ number_format($item->pivot->price, 0, '.', '.') }}
                                        </td>
                                        <td>{{ $item->pivot->discount }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                    {{ $item->pivot->isPromo ? 'checked' : '' }} disabled
                                                    id="flexSwitchCheckChecked">
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle">
                                            Rp{{ number_format($item->price * $item->pivot->qty - $item->pivot->discount, 0, '.', '.') }}
                                        </td>
                                    </tr>
                                    @php
                                        $total += $item->price * $item->pivot->qty - $item->pivot->discount;
                                    @endphp
                                @endforeach
                                @foreach ($transaction->drugMedDevs as $dmd)
                                    <tr>
                                        <td>{{ $loop->iteration + $transaction->actions->count() }}</td>
                                        <td style="width:250px">
                                            {{ $dmd->name }}
                                        </td>
                                        <td>
                                            {{ $dmd->pivot->qty }}
                                        </td>
                                        <td style="vertical-align: middle">{{ $dmd->uom }}</td>
                                        <td style="vertical-align: middle">{{ $dmd->type }}</td>
                                        <td style="vertical-align: middle">{{ $dmd->pivot->rule }}</td>
                                        <td style="vertical-align: middle">{{ $dmd->pivot->how_to_use }}</td>
                                        <td style="vertical-align: middle">
                                            Rp{{ number_format($dmd->pivot->price, 0, '.', '.') }}</td>
                                        <td>{{ $dmd->pivot->discount }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                    {{ $dmd->pivot->isPromo ? 'checked' : '' }} disabled
                                                    id="flexSwitchCheckChecked">
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle">
                                            Rp{{ number_format($dmd->pivot->price * $dmd->pivot->qty - $dmd->pivot->discount, 0, '.', '.') }}
                                        </td>
                                    </tr>
                                    @php
                                        $total += $dmd->pivot->price * $dmd->pivot->qty - $dmd->pivot->discount;
                                    @endphp
                                @endforeach
                                @foreach ($transaction->laborates as $lab)
                                    <tr>
                                        <td>{{ $loop->iteration + $transaction->actions->count() + $transaction->drugMedDevs->count() }}
                                        </td>
                                        <td style="width:250px">
                                            {{ $lab->name }}
                                        </td>
                                        <td>
                                            {{ $lab->pivot->qty }}
                                        </td>
                                        <td style="vertical-align: middle">-</td>
                                        <td style="vertical-align: middle">-</td>
                                        <td style="vertical-align: middle">-</td>
                                        <td style="vertical-align: middle">{{ $lab->type }}</td>
                                        <td style="vertical-align: middle">
                                            Rp{{ number_format($lab->pivot->price, 0, '.', '.') }}</td>
                                        <td>{{ $lab->pivot->discount }}</td>
                                        <td>
                                            -
                                        </td>
                                        <td style="vertical-align: middle">
                                            Rp{{ number_format($lab->pivot->price * $lab->pivot->qty - $lab->pivot->discount, 0, '.', '.') }}
                                        </td>
                                    </tr>
                                    @php
                                        $total += $lab->pivot->price * $lab->pivot->qty - $lab->pivot->discount;
                                    @endphp
                                @endforeach
                                <tr>
                                    <td colspan="8" class="fw-bold text-end">Grand Total :</td>
                                    <td>Rp{{ number_format($total, 0, '.', '.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="8" class="fw-bold text-end">Pembayaran :</td>
                                    <td></td>
                                </tr>
                                @foreach ($transaction->paymentMethods as $pm)
                                    @if ($pm->pivot->amount > 0)
                                        <tr>
                                            <td colspan="8" class="fw-bold text-end">
                                                &nbsp;&nbsp;{{ $pm->name }}
                                                {{ $pm->pivot->bank ? '- (' . $pm->pivot->bank . ')' : '' }}
                                            </td>
                                            <td class="">{{ number_format($pm->pivot->amount, 2, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                @if ($transaction->paymentMethods->reduce(fn($a, $b) => $a + $b->pivot->amount) - $total > 0)
                                    <tr>
                                        <td colspan="8" class="fw-bold text-end"><b>Kembalian :</b></td>
                                        <td>{{ number_format($transaction->paymentMethods->reduce(fn($a, $b) => $a + $b->pivot->amount) - $total, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @endif
                                @if (count($transaction->drugMedDevs) == 0 && count($transaction->actions) == 0 && count($transaction->laborates) == 0)
                                    <tr>
                                        <td colspan="9" align="center">Tidak ada data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-page-layout>

@script
    <script>
        $('.cancel-button').click(function() {
            alert('a');
        });
    </script>
@endscript
