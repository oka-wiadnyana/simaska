<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PetugasSatpam extends Model
{
    use HasFactory;
    public $guarded=[];
    public $connection='review';
    public $table='satpam';

 
}
