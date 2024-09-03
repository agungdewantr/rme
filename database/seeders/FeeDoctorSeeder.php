<?php

namespace Database\Seeders;

use App\Models\SipFee;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeeDoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactions = Transaction::with('actions')->get();

        foreach($transactions as $t){
            foreach($t->actions as $c){
                $fee = SipFee::where('action_id', $c->id)->first();

                if ($t->doctor_id) {
                    $healtWorkerDoctor = User::with('healthWorker')->where('id', $t->doctor_id)->first();
                    $sip = $healtWorkerDoctor->healthWorker->practice_license ?? null;

                    // Determine the doctor's fee based on the SIP
                    $fee_doctor = $sip ? ($fee->sip_fee ?? 0) : ($fee->non_sip_fee ?? 0);

                    if ($c->pivot->discount > 0) {
                        if (!$c->pivot->isPromo) {
                            $fee_doctor = $fee_doctor * (($c->price - $c->pivot->discount)/ $c->price);
                        }
                    }
                    $c->pivot->doctor_fee = $fee_doctor;
                    $c->pivot->save();
                }
            }
        }
    }
}
