<?php

namespace App\Livewire\DrugAndMedDev;

use App\Models\ActivityLog;
use App\Models\CategoryDrugMedDev;
use App\Models\DrugMedDev;
use App\Models\JenisDrugMedDev;
use App\Traits\UploadFile;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

class Create extends Component
{
    use WithFileUploads, UploadFile;

    #[Validate('nullable|image|max:4096', as: 'Foto')]
    public $photo;

    #[Validate('required', as: 'Nama')]
    public $name;

    #[Validate('required|in:Obat,Alat Kesehatan', as: 'Tipe')]
    public $type;

    #[Validate('required', as: 'Satuan')]
    public $uom;

//    #[Validate('required|numeric', as: 'Harga Beli')]
    public $purchase_price;

    #[Validate('required|numeric', as: 'Harga Jual')]
    public $selling_price;

    #[Validate('nullable|numeric', as: 'Minimum Stok')]
    public $min_stock;

    #[Validate('nullable|boolean')]
    public $is_can_minus = false;

    #[Validate('required', as: 'Tanggal Kadaluarsa')]
    public $expired_date;

    #[Validate('required', as: 'Jenis')]
    public $jenis;

    #[Validate('required', as: 'Kategori')]
    public $id_category;


    public function render()
    {
        $this->authorize('create', DrugMedDev::class);
        return view('livewire.drug-and-med-dev.create', [
            'categories' => CategoryDrugMedDev::orderBy('id', 'asc')->get()
        ]);
    }

    #[On('drug-and-med-dev-create')]
    public function save()
    {
        if (!$this->expired_date) {
            Toaster::error('Tanggal kadaluarsa wajib diisi');
            return;
        }
        $this->validate();


        $this->authorize('create', DrugMedDev::class);
        try {
            $drugMedDev = new DrugMedDev();
            if ($this->photo) {
                $drugMedDev->photo = $this->upload('drug-med-dev', $this->photo);
            }
            $drugMedDev->name = $this->name;
            $drugMedDev->id_category = $this->id_category;
            $drugMedDev->jenis = $this->jenis;
            $drugMedDev->type = $this->type;
            $drugMedDev->expired_date = Carbon::parse($this->expired_date);
            $drugMedDev->uom = $this->uom;
            $drugMedDev->purchase_price = (int)filter_var($this->purchase_price ?? 0, FILTER_SANITIZE_NUMBER_INT);
            $drugMedDev->selling_price = (int)filter_var($this->selling_price, FILTER_SANITIZE_NUMBER_INT);
            $drugMedDev->min_stock = $this->min_stock ?? 0;
            $drugMedDev->stock = $this->min_stock ?? 0;
            $drugMedDev->is_can_minus = $this->is_can_minus;
            $drugMedDev->save();

            $log = new ActivityLog();
            $log->author = auth()->user()->name;
            $log->model = 'DrugMedDev';
            $log->model_id = $drugMedDev->id;
            $log->log = 'Telah membuat obat atau alat medis';
            $log->save();

            Toaster::success('Obat atau Alat Kesehatan berhasil dibuat');
            return $this->redirectRoute('drug-and-med-dev.index', navigate: true);
        } catch (\Throwable $th) {
            dd($th);
            Toaster::error('Gagal buat data. Silakan coba beberapa saat lagi');
        }
    }
}
