<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class ResultReviewPtsp extends Model
{
    use HasFactory;
    public $guarded=[];
    public $connection='review';
    public $table='result';

    public function officerName():HasOne{
        return $this->hasOne(Officer::class,'id','officer_id');
    }
    public function unitName():HasOneThrough{
        return $this->hasOneThrough(UnitReview::class,Officer::class,'id','id','officer_id','unit_id');
    }
}
