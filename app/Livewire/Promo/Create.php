<?php

namespace App\Livewire\Promo;

use App\Models\ActivityLog;
use App\Models\Promo;
use App\Traits\UploadFile;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class Create extends ModalComponent
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
    public function render()
    {
        return view('livewire.promo.create');
    }

    public function save()
    {
        $this->validate();
        try {
            $newPromo = new Promo();
            if ($this->cover) {
                $newPromo->cover = $this->upload('promo', $this->cover);
            }
            $newPromo->title = $this->title;
            $newPromo->description = $this->description;
            $newPromo->date = Carbon::parse($this->date)->format('Y-m-d');
            $newPromo->category = $this->category;
            $newPromo->save();

            $log = new ActivityLog();
            $log->author = auth()->user()->name;
            $log->model = 'Promo';
            $log->model_id = $newPromo->id;
            $log->log = 'Telah membuat promo & event';
            $log->save();
            Toaster::success('Promo & Event berhasil dibuat');
            $this->dispatch('promo-refresh');
            $this->closeModal();


        } catch (\Throwable $th) {
            Toaster::error('Gagal buat. Coba beberapa saat lagi');
        }
    }
}
