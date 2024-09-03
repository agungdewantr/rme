<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DrugMedDev extends Model
{
    use HasFactory, Uuid;

    protected $guarded = ['id'];

    public function medicalRecords(): BelongsToMany
    {
        return $this->belongsToMany(MedicalRecord::class, 'medical_record_has_drug_med_devs', 'drug_med_dev_id', 'medical_record_id')->withPivot(['total', 'rule']);
    }

    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class, 'payment_drugs', 'drug_med_dev_id', 'transaction_id')->withPivot(['discount', 'qty']);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryDrugMedDev::class, 'id_category');
    }

    public function stockEntries(): BelongsToMany
    {
        return $this->belongsToMany(StockEntry::class, 'batches', 'item_id', 'stock_entry_id')
            ->withPivot(['qty', 'expired_date', 'batch_number', 'new_price'])->withTimestamps();
    }

    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class, 'item_id');
    }

    public function drugMedDevPriceHistory(): HasMany
    {
        return $this->hasMany(DrugMedDevPriceHistory::class, 'drug_med_dev_id');
    }
}
