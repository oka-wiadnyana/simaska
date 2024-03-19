<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class ResultReviewSatpam extends Model
{
    use HasFactory;
    public $guarded=[];
    public $connection='review';
    public $table='satpam_result';

    public function officerName():HasOne{
        return $this->hasOne(PetugasSatpam::class,'id','officer_id');
    }
 
}
