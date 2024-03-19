<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitReview extends Model
{
    use HasFactory;
    public $table='unit';
    public $guarded=[];
    public $connection='review';
}
