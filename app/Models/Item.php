<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Item extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function sets()
    {
        return $this->belongsToMany(Set::class,'set_items','set_id','item_id');

    }


}
