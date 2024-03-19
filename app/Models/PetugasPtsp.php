<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PetugasPtsp extends Model
{
    use HasFactory;
    public $guarded=[];
    public $connection='review';
    public $table='officer';

    public function unitName():HasOne{
        return $this->hasOne(UnitReview::class,'id','unit_id');
    }
}
