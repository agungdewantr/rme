<?php

namespace App\Livewire\DrugAndMedDev;

use App\Models\ActivityLog;
use App\Models\CategoryDrugMedDev;
use App\Models\DrugMedDev;
use App\Traits\UploadFile;
use Carbon\Carbon;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Storage;
use Toaster;

class Edit extends Component
{
    use WithFileUploads, UploadFile;

    #[Locked]
    public ?DrugMedDev $drugMedDev;

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

    public $stock;

    #[Validate('nullable|boolean')]
    public $is_can_minus = false;

    #[Validate('required', as: 'Tanggal Kadaluarsa')]
    public $expired_date;

    #[Validate('required', as: 'Jenis')]
    public $jenis;

    #[Validate('required', as: 'Kategori')]
    public $id_category;

    public function mount(DrugMedDev $drugMedDev)
    {
        $this->drugMedDev = $drugMedDev->load(['batches' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }, 'drugMedDevPriceHistory.user']);
        $this->name = $drugMedDev->name;
        $this->type = $drugMedDev->type;
        $this->uom = $drugMedDev->uom;
        $this->purchase_price = number_format($drugMedDev->purchase_price, 0, ',', '.');
        $this->selling_price = number_format($drugMedDev->selling_price, 0, ',', '.');
        $this->min_stock = $drugMedDev->min_stock;
        $this->stock = $drugMedDev->stock;
        $this->is_can_minus = $drugMedDev->is_can_minus;
        $this->id_category = $drugMedDev->id_category;
        $this->jenis = $drugMedDev->jenis;
        $this->expired_date = Carbon::parse($drugMedDev->expired_date)->format('d-m-Y');
    }

    public function render()
    {
        $this->authorize('update', $this->drugMedDev);
        return view('livewire.drug-and-med-dev.edit', [
            'logs' => ActivityLog::where('model_id', $this->drugMedDev->id)->where('model', 'DrugMedDev')->latest()->get(),
            'categories' => CategoryDrugMedDev::orderBy('id', 'asc')->get(),
            'batches' => $this->drugMedDev->batches,
            'drugMedDevPriceHistory' => $this->drugMedDev->drugMedDevPriceHistory
        ]);
    }

    #[On('drug-and-med-dev-update')]
    public function save()
    {
        $this->validate();

        $this->authorize('update', $this->drugMedDev);

        if (!$this->expired_date) {
            Toaster::error('Tanggal kadaluarsa wajib diisi');
            return;
        }

        $drugMedDev = DrugMedDev::find($this->drugMedDev->id);
        // try {
        if ($this->photo) {
            if ($drugMedDev->photo && Storage::exists($drugMedDev->photo)) {
                Storage::delete($drugMedDev->photo);
            }
            $drugMedDev->photo = $this->upload('drug-med-dev', $this->photo);
        }
        $drugMedDev->name = $this->name;
        $drugMedDev->type = $this->type;
        $drugMedDev->uom = $this->uom;
        $drugMedDev->purchase_price = (int)filter_var($this->purchase_price ?? 0, FILTER_SANITIZE_NUMBER_INT);
        $drugMedDev->selling_price = (int)filter_var($this->selling_price, FILTER_SANITIZE_NUMBER_INT);
        $drugMedDev->min_stock = $this->min_stock ?? 0;
        $drugMedDev->stock = $this->min_stock ?? 0;
        $drugMedDev->is_can_minus = $this->is_can_minus;
        $drugMedDev->jenis = $this->jenis;
        $drugMedDev->id_category = $this->id_category;
        $drugMedDev->expired_date = Carbon::parse($this->expired_date);
        $drugMedDevDirtyAttributes = $drugMedDev->getDirty();
        $drugMedDev->save();

        if (!empty($drugMedDevDirtyAttributes)) {
            // Log the changes to an audit table
            $attributeChanged = collect();
            foreach ($drugMedDevDirtyAttributes as $attribute => $newValue) {
                $oldValue = $this->drugMedDev->getOriginal($attribute); // Get the original value
                // Log the change with attribute name, old value, and new value
                if ($attribute == 'selling_price') {
                    $this->drugMedDev->drugMedDevPriceHistory()->create([
                        'old_price' => $oldValue,
                        'new_price' => $newValue,
                        'user_id' => auth()->user()->getAuthIdentifier()
                    ]);
                }
                $attributeChanged->push($attribute . ' dari ' . $oldValue . ' ke ' . $newValue);
            }
            $log = new ActivityLog();
            $log->author = auth()->user()->name;
            $log->model = 'DrugMedDev';
            $log->model_id = $this->drugMedDev->id;
            $log->log = 'Mengubah rekam medis pada isian ' . $attributeChanged->join(', ');
            $log->save();
        }

        Toaster::success('Obat atau Alat Kesehatan berhasil diubah');
        return $this->redirectRoute('drug-and-med-dev.index', navigate: true);
        // } catch (\Throwable $th) {
        //     Toaster::error('Gagal buat data. Silakan coba beberapa saat lagi');
        // }
    }
}
