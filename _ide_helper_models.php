<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Account
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account query()
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereUpdatedAt($value)
 */
	class Account extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Action
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $price
 * @property string $category
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicalRecord> $medicalRecords
 * @property-read int|null $medical_records_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PaymentAction> $paymentAction
 * @property-read int|null $payment_action_count
 * @property-read \App\Models\SipFee $sipFee
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Action newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Action newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Action query()
 * @method static \Illuminate\Database\Eloquent\Builder|Action whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Action whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Action whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Action whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Action wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Action whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Action whereUuid($value)
 */
	class Action extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ActivityLog
 *
 * @property int $id
 * @property string $model
 * @property int $model_id
 * @property string $author
 * @property string $log
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereLog($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereUpdatedAt($value)
 */
	class ActivityLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AllergyHistory
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicalRecord> $medicalRecords
 * @property-read int|null $medical_records_count
 * @method static \Illuminate\Database\Eloquent\Builder|AllergyHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AllergyHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AllergyHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|AllergyHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllergyHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllergyHistory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllergyHistory whereUpdatedAt($value)
 */
	class AllergyHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Batch
 *
 * @property int $id
 * @property string $batch_number
 * @property string $expired_date
 * @property string $new_price
 * @property int $qty
 * @property int $item_id
 * @property int $stock_entry_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $qty_ori
 * @property-read \App\Models\DrugMedDev $item
 * @property-read \App\Models\StockEntry $stockEntry
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StockTransfer> $stockTransfers
 * @property-read int|null $stock_transfers_count
 * @method static \Illuminate\Database\Eloquent\Builder|Batch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Batch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Batch query()
 * @method static \Illuminate\Database\Eloquent\Builder|Batch whereBatchNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Batch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Batch whereExpiredDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Batch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Batch whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Batch whereNewPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Batch whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Batch whereQtyOri($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Batch whereStockEntryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Batch whereUpdatedAt($value)
 */
	class Batch extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Branch
 *
 * @property int $id
 * @property string $uuid
 * @property string|null $name
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $is_active
 * @property string|null $phone_number
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OperationalHour> $operationHour
 * @property-read int|null $operation_hour_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Poli> $poli
 * @property-read int|null $poli_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Registration> $registrations
 * @property-read int|null $registrations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StockEntry> $stockEntry
 * @property-read int|null $stock_entry_count
 * @method static \Illuminate\Database\Eloquent\Builder|Branch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch query()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereUuid($value)
 */
	class Branch extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CategoryDrugMedDev
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryDrugMedDev newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryDrugMedDev newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryDrugMedDev query()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryDrugMedDev whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryDrugMedDev whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryDrugMedDev whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryDrugMedDev whereUpdatedAt($value)
 */
	class CategoryDrugMedDev extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CategoryOutcome
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryOutcome newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryOutcome newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryOutcome query()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryOutcome whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryOutcome whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryOutcome whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryOutcome whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryOutcome whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryOutcome whereUuid($value)
 */
	class CategoryOutcome extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Check
 *
 * @property int $id
 * @property string $type
 * @property string $file
 * @property string $date
 * @property int $medical_record_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MedicalRecord $medicalRecord
 * @method static \Illuminate\Database\Eloquent\Builder|Check newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Check newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Check query()
 * @method static \Illuminate\Database\Eloquent\Builder|Check whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Check whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Check whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Check whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Check whereMedicalRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Check whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Check whereUpdatedAt($value)
 */
	class Check extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CheckUp
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property bool $is_active
 * @property int $poli_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CheckUp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CheckUp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CheckUp query()
 * @method static \Illuminate\Database\Eloquent\Builder|CheckUp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckUp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckUp whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckUp whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckUp wherePoliId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckUp whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CheckUp whereUuid($value)
 */
	class CheckUp extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\City
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUpdatedAt($value)
 */
	class City extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Clinic
 *
 * @property int $id
 * @property string|null $name
 * @property bool|null $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Clinic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Clinic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Clinic query()
 * @method static \Illuminate\Database\Eloquent\Builder|Clinic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinic whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinic whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clinic whereUpdatedAt($value)
 */
	class Clinic extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DetailOutcome
 *
 * @property int $id
 * @property int $outcomes_id
 * @property int|null $stock_entry_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $uuid
 * @property-read \App\Models\Outcome $outcome
 * @property-read \App\Models\StockEntry|null $stockEntry
 * @method static \Illuminate\Database\Eloquent\Builder|DetailOutcome newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DetailOutcome newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DetailOutcome query()
 * @method static \Illuminate\Database\Eloquent\Builder|DetailOutcome whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailOutcome whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailOutcome whereOutcomesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailOutcome whereStockEntryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailOutcome whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailOutcome whereUuid($value)
 */
	class DetailOutcome extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DrugMedDev
 *
 * @property int $id
 * @property string $name
 * @property string $jenis
 * @property int $min_stock
 * @property string $uom
 * @property string $purchase_price
 * @property string $selling_price
 * @property bool $is_can_minus
 * @property string|null $photo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $stock
 * @property string $uuid
 * @property string|null $type
 * @property string|null $expired_date
 * @property int|null $id_category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Batch> $batches
 * @property-read int|null $batches_count
 * @property-read \App\Models\CategoryDrugMedDev|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DrugMedDevPriceHistory> $drugMedDevPriceHistory
 * @property-read int|null $drug_med_dev_price_history_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicalRecord> $medicalRecords
 * @property-read int|null $medical_records_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StockEntry> $stockEntries
 * @property-read int|null $stock_entries_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDev newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDev newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDev query()
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDev whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDev whereExpiredDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDev whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDev whereIdCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDev whereIsCanMinus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDev whereJenis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDev whereMinStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDev whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDev wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDev wherePurchasePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDev whereSellingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDev whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDev whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDev whereUom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDev whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDev whereUuid($value)
 */
	class DrugMedDev extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DrugMedDevPriceHistory
 *
 * @property int $id
 * @property int $old_price
 * @property int $new_price
 * @property int $drug_med_dev_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DrugMedDev $drugMedDev
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDevPriceHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDevPriceHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDevPriceHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDevPriceHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDevPriceHistory whereDrugMedDevId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDevPriceHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDevPriceHistory whereNewPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDevPriceHistory whereOldPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDevPriceHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DrugMedDevPriceHistory whereUserId($value)
 */
	class DrugMedDevPriceHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmergencyContact
 *
 * @property int $id
 * @property string $name
 * @property string $relationship
 * @property string $address
 * @property string $phone_number
 * @property int $patient_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $job
 * @property-read \App\Models\Patient $patient
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereJob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereRelationship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereUpdatedAt($value)
 */
	class EmergencyContact extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FamilyIllnessHistory
 *
 * @property int $id
 * @property int $patient_id
 * @property string $name
 * @property string $relationship
 * @property string $disease_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyIllnessHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyIllnessHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyIllnessHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyIllnessHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyIllnessHistory whereDiseaseName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyIllnessHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyIllnessHistory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyIllnessHistory wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyIllnessHistory whereRelationship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyIllnessHistory whereUpdatedAt($value)
 */
	class FamilyIllnessHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FirstEntry
 *
 * @property int $id
 * @property string $uuid
 * @property string $time_stamp
 * @property int|null $doctor_id
 * @property int $nurse_id
 * @property string|null $hpht
 * @property string|null $edd
 * @property string $main_complaint
 * @property string|null $specific_attention
 * @property int $patient_id
 * @property int|null $registration_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $patient_awareness
 * @property string|null $neck
 * @property string|null $head
 * @property string|null $chest
 * @property string|null $eye
 * @property string|null $abdomen
 * @property string|null $heart
 * @property string|null $extremities
 * @property string|null $lungs
 * @property string|null $skin
 * @property string|null $date_lab
 * @property float|null $height
 * @property float|null $weight
 * @property float|null $body_temperature
 * @property float|null $sistole
 * @property float|null $diastole
 * @property float|null $pulse
 * @property float|null $respiratory_frequency
 * @property string|null $description_physical
 * @property string|null $blood_type
 * @property string|null $random_blood_sugar
 * @property string|null $hemoglobin
 * @property string|null $hbsag
 * @property string|null $hiv
 * @property string|null $syphilis
 * @property string|null $urine_reduction
 * @property string|null $urine_protein
 * @property-read \App\Models\User|null $doctor
 * @property-read \App\Models\User $nurse
 * @property-read \App\Models\Patient $patient
 * @property-read \App\Models\Registration|null $registration
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry query()
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereAbdomen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereBloodType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereBodyTemperature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereChest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereDateLab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereDescriptionPhysical($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereDiastole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereEdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereExtremities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereEye($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereHbsag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereHead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereHeart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereHemoglobin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereHiv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereHpht($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereLungs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereMainComplaint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereNeck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereNurseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry wherePatientAwareness($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry wherePulse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereRandomBloodSugar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereRegistrationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereRespiratoryFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereSistole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereSkin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereSpecificAttention($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereSyphilis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereTimeStamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereUrineProtein($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereUrineReduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntry whereWeight($value)
 */
	class FirstEntry extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FirstEntryHasAllergiesHistory
 *
 * @property int $id
 * @property int $first_entry_id
 * @property int $allergy_history_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AllergyHistory $allergy
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntryHasAllergiesHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntryHasAllergiesHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntryHasAllergiesHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntryHasAllergiesHistory whereAllergyHistoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntryHasAllergiesHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntryHasAllergiesHistory whereFirstEntryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntryHasAllergiesHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntryHasAllergiesHistory whereUpdatedAt($value)
 */
	class FirstEntryHasAllergiesHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FirstEntryHasIllnessHistory
 *
 * @property int $id
 * @property int $first_entry_id
 * @property int $illness_history_id
 * @property string $therapy
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntryHasIllnessHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntryHasIllnessHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntryHasIllnessHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntryHasIllnessHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntryHasIllnessHistory whereFirstEntryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntryHasIllnessHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntryHasIllnessHistory whereIllnessHistoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntryHasIllnessHistory whereTherapy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirstEntryHasIllnessHistory whereUpdatedAt($value)
 */
	class FirstEntryHasIllnessHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HealthWorker
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $position
 * @property string $phone_number
 * @property string $email
 * @property string|null $practice_license
 * @property bool $status
 * @property string $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $gender
 * @property int|null $user_id
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|HealthWorker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HealthWorker newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HealthWorker query()
 * @method static \Illuminate\Database\Eloquent\Builder|HealthWorker whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthWorker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthWorker whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthWorker whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthWorker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthWorker whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthWorker wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthWorker wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthWorker wherePracticeLicense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthWorker whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthWorker whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthWorker whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthWorker whereUuid($value)
 */
	class HealthWorker extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Icd
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Icd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Icd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Icd query()
 * @method static \Illuminate\Database\Eloquent\Builder|Icd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Icd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Icd whereUpdatedAt($value)
 */
	class Icd extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\IllnessHistory
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicalRecord> $medicalRecords
 * @property-read int|null $medical_records_count
 * @method static \Illuminate\Database\Eloquent\Builder|IllnessHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IllnessHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IllnessHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|IllnessHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IllnessHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IllnessHistory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IllnessHistory whereUpdatedAt($value)
 */
	class IllnessHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Insurance
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $number
 * @property int $patient_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Insurance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Insurance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Insurance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Insurance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insurance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insurance whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insurance whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insurance wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insurance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Insurance whereUuid($value)
 */
	class Insurance extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Job
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Patient> $patients
 * @property-read int|null $patients_count
 * @method static \Illuminate\Database\Eloquent\Builder|Job newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Job newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Job query()
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereUuid($value)
 */
	class Job extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Laborate
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $type
 * @property string|null $price
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicalRecord> $medicalRecords
 * @property-read int|null $medical_records_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $payments
 * @property-read int|null $payments_count
 * @method static \Illuminate\Database\Eloquent\Builder|Laborate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Laborate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Laborate query()
 * @method static \Illuminate\Database\Eloquent\Builder|Laborate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laborate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laborate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laborate wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laborate whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laborate whereUpdatedAt($value)
 */
	class Laborate extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MainComplaint
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicalRecord> $medicalRecords
 * @property-read int|null $medical_records_count
 * @method static \Illuminate\Database\Eloquent\Builder|MainComplaint newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MainComplaint newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MainComplaint query()
 * @method static \Illuminate\Database\Eloquent\Builder|MainComplaint whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainComplaint whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainComplaint whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainComplaint whereUpdatedAt($value)
 */
	class MainComplaint extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MedicalRecord
 *
 * @property int $id
 * @property string $uuid
 * @property string $medical_record_number
 * @property string $date
 * @property int|null $gravida
 * @property int|null $para
 * @property int|null $hidup
 * @property string|null $birth_description
 * @property int|null $abbortion
 * @property string|null $hpht
 * @property string|null $other_history
 * @property int $user_id
 * @property string|null $patient_awareness
 * @property float|null $height
 * @property float|null $weight
 * @property float|null $body_temperature
 * @property float|null $sistole
 * @property float|null $diastole
 * @property float|null $pulse
 * @property float|null $respiratory_frequency
 * @property string|null $description
 * @property string|null $diagnose
 * @property string|null $ga
 * @property string|null $gs
 * @property string|null $crl
 * @property string|null $ac
 * @property string|null $fhr
 * @property string|null $bpd
 * @property string|null $edd
 * @property string|null $blood_type
 * @property string|null $random_blood_sugar
 * @property string|null $hemoglobin
 * @property string|null $hbsag
 * @property string|null $hiv
 * @property string|null $syphilis
 * @property string|null $urine_reduction
 * @property string|null $urine_protein
 * @property string|null $ph
 * @property string|null $next_control
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $summary
 * @property int|null $doctor_id
 * @property int|null $nurse_id
 * @property string|null $subjective_summary
 * @property string|null $objective_summary
 * @property string|null $assessment_summary
 * @property string|null $plan_summary
 * @property int|null $registration_id
 * @property string|null $other_summary
 * @property string|null $fl
 * @property string|null $efw
 * @property string|null $time_stamp
 * @property int|null $first_entry_id
 * @property string|null $plan_note
 * @property string|null $date_lab
 * @property string|null $other_lab
 * @property string|null $other_recipe
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Action> $actions
 * @property-read int|null $actions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AllergyHistory> $allergyHistories
 * @property-read int|null $allergy_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Check> $checks
 * @property-read int|null $checks_count
 * @property-read \App\Models\User|null $doctor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DrugMedDev> $drugMedDevs
 * @property-read int|null $drug_med_devs_count
 * @property-read \App\Models\FirstEntry|null $firstEntry
 * @property-read \App\Models\HealthWorker|null $healthWorker
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\IllnessHistory> $illnessHistories
 * @property-read int|null $illness_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Laborate> $laborate
 * @property-read int|null $laborate_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MainComplaint> $mainComplaints
 * @property-read int|null $main_complaints_count
 * @property-read \App\Models\User|null $nurse
 * @property-read \App\Models\Registration|null $registration
 * @property-read \App\Models\Transaction|null $transaction
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Usg> $usgs
 * @property-read int|null $usgs_count
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereAbbortion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereAc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereAssessmentSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereBirthDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereBloodType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereBodyTemperature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereBpd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereCrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereDateLab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereDiagnose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereDiastole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereEdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereEfw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereFhr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereFirstEntryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereFl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereGa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereGravida($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereGs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereHbsag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereHemoglobin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereHidup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereHiv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereHpht($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereMedicalRecordNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereNextControl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereNurseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereObjectiveSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereOtherHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereOtherLab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereOtherRecipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereOtherSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord wherePara($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord wherePatientAwareness($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord wherePh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord wherePlanNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord wherePlanSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord wherePulse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereRandomBloodSugar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereRegistrationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereRespiratoryFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereSistole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereSubjectiveSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereSyphilis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereTimeStamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereUrineProtein($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereUrineReduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecord whereWeight($value)
 */
	class MedicalRecord extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MedicalRecordHasAction
 *
 * @property int $id
 * @property int $medical_record_id
 * @property int $action_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $total
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasAction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasAction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasAction query()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasAction whereActionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasAction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasAction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasAction whereMedicalRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasAction whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasAction whereUpdatedAt($value)
 */
	class MedicalRecordHasAction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MedicalRecordHasAllergyHistories
 *
 * @property int $id
 * @property int $medical_record_id
 * @property int $allergy_history_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasAllergyHistories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasAllergyHistories newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasAllergyHistories query()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasAllergyHistories whereAllergyHistoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasAllergyHistories whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasAllergyHistories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasAllergyHistories whereMedicalRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasAllergyHistories whereUpdatedAt($value)
 */
	class MedicalRecordHasAllergyHistories extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MedicalRecordHasDrugMedDev
 *
 * @property int $id
 * @property int $medical_record_id
 * @property int $drug_med_dev_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $total
 * @property string $rule
 * @property string|null $how_to_use
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasDrugMedDev newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasDrugMedDev newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasDrugMedDev query()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasDrugMedDev whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasDrugMedDev whereDrugMedDevId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasDrugMedDev whereHowToUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasDrugMedDev whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasDrugMedDev whereMedicalRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasDrugMedDev whereRule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasDrugMedDev whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasDrugMedDev whereUpdatedAt($value)
 */
	class MedicalRecordHasDrugMedDev extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MedicalRecordHasIllnessHistory
 *
 * @property int $id
 * @property int $medical_record_id
 * @property int $illness_history_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasIllnessHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasIllnessHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasIllnessHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasIllnessHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasIllnessHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasIllnessHistory whereIllnessHistoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasIllnessHistory whereMedicalRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasIllnessHistory whereUpdatedAt($value)
 */
	class MedicalRecordHasIllnessHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MedicalRecordHasMainComplaint
 *
 * @property int $id
 * @property int $medical_record_id
 * @property int $main_complaint_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasMainComplaint newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasMainComplaint newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasMainComplaint query()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasMainComplaint whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasMainComplaint whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasMainComplaint whereMainComplaintId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasMainComplaint whereMedicalRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalRecordHasMainComplaint whereUpdatedAt($value)
 */
	class MedicalRecordHasMainComplaint extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Obstetri
 *
 * @property int $id
 * @property int $patient_id
 * @property int|null $gender
 * @property int|null $weight
 * @property string|null $type_of_birth
 * @property string|null $birth_date
 * @property string|null $clinical_information
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $age
 * @method static \Illuminate\Database\Eloquent\Builder|Obstetri newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Obstetri newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Obstetri query()
 * @method static \Illuminate\Database\Eloquent\Builder|Obstetri whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Obstetri whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Obstetri whereClinicalInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Obstetri whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Obstetri whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Obstetri whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Obstetri wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Obstetri whereTypeOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Obstetri whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Obstetri whereWeight($value)
 */
	class Obstetri extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OperationalHour
 *
 * @property int $id
 * @property bool|null $active
 * @property int $branch_id
 * @property string|null $day
 * @property string|null $shift
 * @property string|null $open
 * @property string|null $close
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OperationalHour newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OperationalHour newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OperationalHour query()
 * @method static \Illuminate\Database\Eloquent\Builder|OperationalHour whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperationalHour whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperationalHour whereClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperationalHour whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperationalHour whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperationalHour whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperationalHour whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperationalHour whereShift($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperationalHour whereUpdatedAt($value)
 */
	class OperationalHour extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Outcome
 *
 * @property int $id
 * @property string $category
 * @property string $payment_method
 * @property string $date
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $code
 * @property int|null $branch_id
 * @property string $uuid
 * @property string|null $status
 * @property int|null $nominal
 * @property int|null $account_id
 * @property int|null $supplier_id
 * @property-read \App\Models\Account|null $account
 * @property-read \App\Models\Branch|null $branch
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DetailOutcome> $detailOutcome
 * @property-read int|null $detail_outcome_count
 * @property-read \App\Models\Supplier|null $supplier
 * @method static \Illuminate\Database\Eloquent\Builder|Outcome newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Outcome newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Outcome query()
 * @method static \Illuminate\Database\Eloquent\Builder|Outcome whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Outcome whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Outcome whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Outcome whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Outcome whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Outcome whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Outcome whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Outcome whereNominal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Outcome whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Outcome wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Outcome whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Outcome whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Outcome whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Outcome whereUuid($value)
 */
	class Outcome extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Patient
 *
 * @property int $id
 * @property string $uuid
 * @property string $patient_number
 * @property string $nik
 * @property string $name
 * @property string|null $pob
 * @property string|null $dob
 * @property string $phone_number
 * @property bool|null $gender
 * @property string|null $address
 * @property string|null $city
 * @property string|null $blood_type
 * @property string|null $photo_profile
 * @property int|null $job_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $status_pernikahan
 * @property string|null $citizenship
 * @property string|null $husbands_name
 * @property string|null $husbands_nik
 * @property string|null $husbands_address
 * @property string|null $husbands_citizenship
 * @property string|null $husbands_job
 * @property string|null $husbands_birth_date
 * @property string|null $age_of_marriage
 * @property string|null $husbands_phone_number
 * @property string|null $husbands_note
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AllergyHistory> $allergyHistories
 * @property-read int|null $allergy_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmergencyContact> $emergencyContacts
 * @property-read int|null $emergency_contacts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FamilyIllnessHistory> $familyIlnessHistories
 * @property-read int|null $family_ilness_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FirstEntry> $firstEntry
 * @property-read int|null $first_entry_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\IllnessHistory> $illnessHistories
 * @property-read int|null $illness_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Insurance> $insurances
 * @property-read int|null $insurances_count
 * @property-read \App\Models\Job|null $job
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Obstetri> $obstetri
 * @property-read int|null $obstetri_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Registration> $registration
 * @property-read int|null $registration_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transaction
 * @property-read int|null $transaction_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Patient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient query()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereAgeOfMarriage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereBloodType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereCitizenship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereHusbandsAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereHusbandsBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereHusbandsCitizenship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereHusbandsJob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereHusbandsName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereHusbandsNik($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereHusbandsNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereHusbandsPhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereJobId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereNik($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient wherePatientNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient wherePhotoProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient wherePob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereStatusPernikahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereUuid($value)
 */
	class Patient extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PatientHasAllergyHistories
 *
 * @property int $id
 * @property int $patient_id
 * @property int $allergy_history_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $indication
 * @method static \Illuminate\Database\Eloquent\Builder|PatientHasAllergyHistories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientHasAllergyHistories newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientHasAllergyHistories query()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientHasAllergyHistories whereAllergyHistoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientHasAllergyHistories whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientHasAllergyHistories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientHasAllergyHistories whereIndication($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientHasAllergyHistories wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientHasAllergyHistories whereUpdatedAt($value)
 */
	class PatientHasAllergyHistories extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PatientHasIllnessHistories
 *
 * @property int $id
 * @property int $patient_id
 * @property int $illness_history_id
 * @property string $therapy
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PatientHasIllnessHistories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientHasIllnessHistories newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientHasIllnessHistories query()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientHasIllnessHistories whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientHasIllnessHistories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientHasIllnessHistories whereIllnessHistoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientHasIllnessHistories wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientHasIllnessHistories whereTherapy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientHasIllnessHistories whereUpdatedAt($value)
 */
	class PatientHasIllnessHistories extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PaymentAction
 *
 * @property int $id
 * @property int $transaction_id
 * @property int $action_id
 * @property string $discount
 * @property string $qty
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $price
 * @property bool|null $isPromo
 * @property-read \App\Models\Action $action
 * @property-read \App\Models\Transaction $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAction query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAction whereActionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAction whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAction whereIsPromo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAction wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAction whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAction whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAction whereUpdatedAt($value)
 */
	class PaymentAction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PaymentDrug
 *
 * @property int $id
 * @property int $transaction_id
 * @property int $drug_med_dev_id
 * @property string $discount
 * @property string $qty
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $batch_id
 * @property string|null $how_to_use
 * @property string|null $rule
 * @property int $price
 * @property bool|null $isPromo
 * @property-read \App\Models\DrugMedDev $drugMedDev
 * @property-read \App\Models\Transaction $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDrug newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDrug newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDrug query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDrug whereBatchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDrug whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDrug whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDrug whereDrugMedDevId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDrug whereHowToUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDrug whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDrug whereIsPromo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDrug wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDrug whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDrug whereRule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDrug whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDrug whereUpdatedAt($value)
 */
	class PaymentDrug extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PaymentMethod
 *
 * @property int $id
 * @property string $name
 * @property bool $is_bank
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereIsBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereUpdatedAt($value)
 */
	class PaymentMethod extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Poli
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool|null $is_active
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Branch> $branch
 * @property-read int|null $branch_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CheckUp> $checkups
 * @property-read int|null $checkups_count
 * @method static \Illuminate\Database\Eloquent\Builder|Poli newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Poli newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Poli query()
 * @method static \Illuminate\Database\Eloquent\Builder|Poli whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Poli whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Poli whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Poli whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Poli whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Poli whereUuid($value)
 */
	class Poli extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Promo
 *
 * @property int $id
 * @property string $uuid
 * @property string $title
 * @property string $cover
 * @property string $category
 * @property string $date
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Promo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Promo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Promo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Promo whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promo whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promo whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promo whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promo whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promo whereUuid($value)
 */
	class Promo extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Registration
 *
 * @property int $id
 * @property string $uuid
 * @property int|null $queue_number
 * @property string $date
 * @property string|null $type
 * @property string $estimated_arrival
 * @property int $branch_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $status
 * @property string|null $finance_type
 * @property string|null $poli
 * @property string|null $estimated_hour
 * @property string|null $checkup
 * @property-read \App\Models\Branch $branch
 * @property-read \App\Models\FirstEntry|null $firstEntry
 * @property-read \App\Models\MedicalRecord|null $medicalRecord
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Registration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Registration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Registration query()
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereCheckup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereEstimatedArrival($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereEstimatedHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereFinanceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration wherePoli($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereQueueNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereUuid($value)
 */
	class Registration extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUuid($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string $field
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereField($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereValue($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SipFee
 *
 * @property int $id
 * @property int $action_id
 * @property string $sip_fee
 * @property string $non_sip_fee
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Action $action
 * @method static \Illuminate\Database\Eloquent\Builder|SipFee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SipFee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SipFee query()
 * @method static \Illuminate\Database\Eloquent\Builder|SipFee whereActionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SipFee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SipFee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SipFee whereNonSipFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SipFee whereSipFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SipFee whereUpdatedAt($value)
 */
	class SipFee extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\StockEntry
 *
 * @property int $id
 * @property string $uuid
 * @property string $stock_entry_number
 * @property string $date
 * @property string $purpose
 * @property string|null $status
 * @property int $receiver_id
 * @property int $branch_id
 * @property int|null $supplier_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $description
 * @property int|null $grand_total
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Batch> $batches
 * @property-read int|null $batches_count
 * @property-read \App\Models\Branch $branch
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StockManagementDetail> $details
 * @property-read int|null $details_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DrugMedDev> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Supplier|null $supplier
 * @method static \Illuminate\Database\Eloquent\Builder|StockEntry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockEntry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockEntry query()
 * @method static \Illuminate\Database\Eloquent\Builder|StockEntry whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockEntry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockEntry whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockEntry whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockEntry whereGrandTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockEntry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockEntry wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockEntry whereReceiverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockEntry whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockEntry whereStockEntryNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockEntry whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockEntry whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockEntry whereUuid($value)
 */
	class StockEntry extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\StockLedger
 *
 * @property int $id
 * @property string $document_reference
 * @property int $current_qty
 * @property int $in
 * @property int $out
 * @property int $qty
 * @property int $item_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $batch_reference
 * @property-read \App\Models\Batch|null $batch
 * @property-read \App\Models\Transaction|null $invoice
 * @property-read \App\Models\DrugMedDev $item
 * @property-read \App\Models\StockEntry|null $stockEntry
 * @method static \Illuminate\Database\Eloquent\Builder|StockLedger newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockLedger newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockLedger query()
 * @method static \Illuminate\Database\Eloquent\Builder|StockLedger whereBatchReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockLedger whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockLedger whereCurrentQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockLedger whereDocumentReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockLedger whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockLedger whereIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockLedger whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockLedger whereOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockLedger whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockLedger whereUpdatedAt($value)
 */
	class StockLedger extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\StockManagementDetail
 *
 * @property int $id
 * @property string $item_name
 * @property string $item_uom
 * @property int $item_qty
 * @property int $item_price
 * @property string $item_expired_date
 * @property int $stock_entry_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\StockEntry $stockEntry
 * @method static \Illuminate\Database\Eloquent\Builder|StockManagementDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockManagementDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockManagementDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|StockManagementDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockManagementDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockManagementDetail whereItemExpiredDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockManagementDetail whereItemName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockManagementDetail whereItemPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockManagementDetail whereItemQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockManagementDetail whereItemUom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockManagementDetail whereStockEntryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockManagementDetail whereUpdatedAt($value)
 */
	class StockManagementDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\StockTransfer
 *
 * @property int $id
 * @property string $uuid
 * @property string $stock_transfer_number
 * @property string $date
 * @property string $status
 * @property string|null $description
 * @property int $form_branch_id
 * @property int $to_branch_id
 * @property int $payment_method_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $grand_total
 * @property int|null $amount
 * @property int|null $receiver_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Batch> $batches
 * @property-read int|null $batches_count
 * @property-read \App\Models\Branch $fromBranch
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DrugMedDev> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\HealthWorker|null $receiver
 * @property-read \App\Models\Branch $toBranch
 * @method static \Illuminate\Database\Eloquent\Builder|StockTransfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockTransfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockTransfer query()
 * @method static \Illuminate\Database\Eloquent\Builder|StockTransfer whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockTransfer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockTransfer whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockTransfer whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockTransfer whereFormBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockTransfer whereGrandTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockTransfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockTransfer wherePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockTransfer whereReceiverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockTransfer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockTransfer whereStockTransferNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockTransfer whereToBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockTransfer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockTransfer whereUuid($value)
 */
	class StockTransfer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Supplier
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StockEntry> $stockEntries
 * @property-read int|null $stock_entries_count
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier query()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereUpdatedAt($value)
 */
	class Supplier extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TmpData
 *
 * @property int $id
 * @property string $field
 * @property string|null $value
 * @property string $location
 * @property int $user_id
 * @property string $field_type
 * @property int $temp_id
 * @property string $field_group
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TmpData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TmpData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TmpData query()
 * @method static \Illuminate\Database\Eloquent\Builder|TmpData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TmpData whereField($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TmpData whereFieldGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TmpData whereFieldType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TmpData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TmpData whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TmpData whereTempId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TmpData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TmpData whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TmpData whereValue($value)
 */
	class TmpData extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property string $uuid
 * @property string $transaction_number
 * @property string $date
 * @property int|null $medical_record_id
 * @property int|null $doctor_id
 * @property int $patient_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $branch_id
 * @property int|null $poli_id
 * @property string|null $estimated_arrival
 * @property string|null $reference_number
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Action> $actions
 * @property-read int|null $actions_count
 * @property-read \App\Models\Branch|null $branch
 * @property-read \App\Models\User|null $doctor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DrugMedDev> $drugMedDevs
 * @property-read int|null $drug_med_devs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Laborate> $laborates
 * @property-read int|null $laborates_count
 * @property-read \App\Models\MedicalRecord|null $medicalRecord
 * @property-read \App\Models\User $patient
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PaymentMethod> $paymentMethods
 * @property-read int|null $payment_methods_count
 * @property-read \App\Models\Poli|null $poli
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereEstimatedArrival($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereMedicalRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction wherePoliId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereReferenceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTransactionNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUuid($value)
 */
	class Transaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property bool $is_active
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $role_id
 * @property int|null $branch_filter
 * @property int|null $doctor_filter
 * @property-read \App\Models\Branch|null $branch
 * @property-read \App\Models\HealthWorker|null $healthWorker
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Insurance> $insurances
 * @property-read int|null $insurances_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicalRecord> $medicalRecords
 * @property-read int|null $medical_records_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicalRecord> $medicalRecordsDoctor
 * @property-read int|null $medical_records_doctor_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicalRecord> $medicalRecordsNurse
 * @property-read int|null $medical_records_nurse_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Patient|null $patient
 * @property-read \App\Models\Role|null $role
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vaccine> $vaccines
 * @property-read int|null $vaccines_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBranchFilter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDoctorFilter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Usg
 *
 * @property int $id
 * @property string $usg_id
 * @property string $file
 * @property string $date
 * @property int $medical_record_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MedicalRecord $medicalRecord
 * @method static \Illuminate\Database\Eloquent\Builder|Usg newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Usg newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Usg query()
 * @method static \Illuminate\Database\Eloquent\Builder|Usg whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usg whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usg whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usg whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usg whereMedicalRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usg whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usg whereUsgId($value)
 */
	class Usg extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Vaccine
 *
 * @property int $id
 * @property string $name
 * @property string $brand
 * @property string $date
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MedicalRecord|null $medicalRecord
 * @method static \Illuminate\Database\Eloquent\Builder|Vaccine newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vaccine newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vaccine query()
 * @method static \Illuminate\Database\Eloquent\Builder|Vaccine whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vaccine whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vaccine whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vaccine whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vaccine whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vaccine whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vaccine whereUserId($value)
 */
	class Vaccine extends \Eloquent {}
}

