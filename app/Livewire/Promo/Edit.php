<?php

namespace App\Livewire\Promo;

use App\Models\ActivityLog;
use App\Models\Promo;
use App\Traits\UploadFile;
use Carbon\Carbon;
use Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class Edit extends ModalComponent
{
    use WithFileUploads, UploadFile;
    #[Validate('required', as: 'Judul')]
    public $title;
    #[Validate('required', as: 'Tanggal')]
    public $date;
    #[Validate('required', as: 'Deskripsi')]
    public $description;
    #[Validate('required|image|max:4096', as: 'Cover')]
    public $cover;
    #[Validate('required', as: 'Kategori')]
    public $category;

    public ?Promo $promo;

    public function mount($uuid)
    {
        $promo = Promo::where('uuid',$uuid)->first();
        $this->promo = $promo;
        $this->title = $promo->title;
        $this->date = Carbon::parse($promo->date)->format('d-m-Y');
        $this->description = $promo->description;
        $this->category = $promo->category;
        $this->dispatch('loading-edit', false);
    }
    public function render()
    {
        return view('livewire.promo.edit');
    }

    public function save()
    {
        $this->validate();
        try {
            $promo = Promo::find($this->promo->id);
            if ($this->cover) {
                if ($promo->cover && Storage::exists($promo->cover)) {
                    Storage::delete($promo->cover);
                }
                $promo->cover = $this->upload('promo', $this->cover);
            }
            $promo->title = $this->title;
            $promo->description = $this->description;
            $promo->date = Carbon::parse($this->date)->format('Y-m-d');
            $promo->category = $this->category;
            $promo->save();

            // $log = new ActivityLog();
            // $log->author = auth()->user()->name;
            // $log->model = 'Promo';
            // $log->model_id = $promo->id;
            // $log->log = 'Telah membuat promo & event';
            // $log->save();
            Toaster::success('Promo & Event berhasil diubah');
            $this->dispatch('promo-refresh');
            $this->closeModal();


        } catch (\Throwable $th) {
            Toaster::error('Gagal buat. Coba beberapa saat lagi');
        }
    }
}
