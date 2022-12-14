<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instalment extends Model
{
    use HasFactory;

    public function leadgerEntries(){

        return $this->morphMany(GLeadger::class,'transaction');
    }
    
    public function createLeadgerEntry($accound_id,$value,$investor_id,$date,$user_id ){

        $this->leadgerEntries()->create([
            'account_id' => $accound_id,
            'value' => $value,
            'investor_id' => $investor_id,
            'date' => $date,
            'user_id'=>$user_id
        ]);
    }

   
    public function sale(){

        return $this->belongsTo(Sale::class,'sale_id');
    }
    
    public function saleCommision(){
        return $this->morphMany(Commission::class,'transaction');
    }
    public function createInstalmentComision($sale,$user_id,$payment){
       
        $this->saleCommision()->create(
            [
                'commission_type' => 2,
                'user_id' => $sale->rec_of_id,
                'amount' =>  $payment->amount,
                'status' => 0,
                'earned_date' => $payment->payment_date,
                'user_id' =>$user_id,
            ]
        );
    }
    public function instalmentPayments(){
        return $this->hasMany(InstalmentPayment::class,'instalment_id');
    }
}
