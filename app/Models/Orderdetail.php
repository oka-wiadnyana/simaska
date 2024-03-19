<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderdetail extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'nama_barang', 'jumlah_barang', 'satuan', 'jumlah_dipenuhi', 'satuan_dipenuhi', 'complete'];
    public $timestamps = false;
}
