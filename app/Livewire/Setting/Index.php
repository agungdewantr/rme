<?php

namespace App\Livewire\Setting;

use App\Models\Setting;
use App\Traits\UploadFile;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Propaganistas\LaravelPhone\PhoneNumber;
use Storage;
use Toaster;

class Index extends Component
{
    use WithFileUploads, UploadFile;

    #[Validate('nullable|image|max:4096')]
    public $photo;

    public $currentPhoto;

    #[Validate('nullable|email:rfc,dns')]
    public $email;

    #[Validate('nullable|phone:ID')]
    public $phone_number;

    #[Validate('nullable|boolean')]
    public $is_can_minus;

    #[Validate('nullable|numeric')]
    public $float_precision;

    #[Validate('nullable')]
    public $running_text;

    public $header_letter;

    public function mount()
    {
        $this->email = Setting::whereField('email')->first()->value ?? '';
        $this->phone_number = Setting::whereField('phone_number')->first()->value ?? '';
        $this->is_can_minus = @Setting::whereField('is_can_minus')->first()->value == 1 ?? '';
        $this->float_precision = Setting::whereField('float_precision')->first()->value ?? '';
        $this->header_letter = Setting::whereField('header_letter')->first()->value ?? '';
        $this->currentPhoto = Setting::whereField('header_logo')->first()->value ?? null;
        $this->running_text = Setting::whereField('running_text')->first()->value ?? null;
    }

    public function render()
    {
        $this->authorize('viewAny', Setting::class);
        return view('livewire.setting.index');
    }

    public function save()
    {
        $this->validate();
        $this->authorize('viewAny', Setting::class);

        $phone_number = new PhoneNumber($this->phone_number, 'ID');
        try {
            Setting::updateOrInsert(
                ['field' => 'email'],
                ['value' => $this->email, 'field' => 'email']
            );
            Setting::updateOrInsert(
                ['field' => 'phone_number'],
                ['value' => $phone_number, 'field' => 'phone_number']
            );
            Setting::updateOrInsert(
                ['field' => 'is_can_minus'],
                ['value' => $this->is_can_minus, 'field' => 'is_can_minus']
            );
            Setting::updateOrInsert(
                ['field' => 'header_letter'],
                ['value' => $this->header_letter, 'field' => 'header_letter']
            );
            Setting::updateOrInsert(
                ['field' => 'float_precision'],
                ['value' => $this->float_precision, 'field' => 'float_precision']
            );
            Setting::updateOrInsert(
                ['field' => 'running_text'],
                ['value' => $this->running_text, 'field' => 'running_text']
            );
            if ($this->photo) {
                if ($this->currentPhoto && Storage::exists($this->currentPhoto)) {
                    Storage::delete($this->currentPhoto);
                }
                Setting::updateOrInsert(
                    ['field' => 'header_logo'],
                    ['value' => $this->upload('setting', $this->photo), 'field' => 'header_logo']
                );
            }
            Toaster::success('Berhasil disimpan');
            $this->redirectRoute('setting.index', navigate: true);
        } catch (\Throwable $th) {
            Toaster::error('Gagal simpan. Coba beberapa saat lagi');
        }
    }
}
