<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Medical History</span>
        <button class="btn" type="button" wire:click="$dispatch('closeModal')">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal <br> Dokter / Perawat</th>
                        <th>Rekam Medis</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$medicalRecord->date}} <br> {{$medicalRecord->doctor->name}} /  {{$medicalRecord->nurse->name}}</td>
                        <td>
                            TB : {{$medicalRecord->height}} cm<br>
                            BB : {{$medicalRecord->weight}} kg<br>
                            EDD : {{$medicalRecord->edd}}<br>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>
