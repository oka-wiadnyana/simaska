<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Officer extends Model
{
    use HasFactory;
    public $table='officer';
    public $guarded=[];
    public $connection='review';

    public function unitName():HasOne{
        return $this->hasOne(UnitReview::class,'id','unit_id');
    }
}
