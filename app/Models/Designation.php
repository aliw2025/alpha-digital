<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    public function pay_Scale(){
        return $this->belongsTo(PayScale::class,'pay_scale');
    }
}
