<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderfullfill extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'orderfullfills_id', 'tanggal'];
    public $timestamps = false;
}
