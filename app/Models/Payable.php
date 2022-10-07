<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payable extends Model
{
    use HasFactory;

    public function purchase()
    {
            return $this->belongsto(Purchase::class,'transaction_id');
    }

   
}
