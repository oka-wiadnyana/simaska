<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['nomor_index', 'nomor_pesanan', 'tanggal_pesanan', 'unit_id', 'employee_id', 'dipa'];
    public $timestamps = false;
}
