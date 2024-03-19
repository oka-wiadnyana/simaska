<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'nip', 'position_id', 'unit_id', 'golongan', 'nomor_hp', 'is_atasan_langsung', 'tgl_awal_mk'];
    public $timestamps = false;

    public function position():BelongsTo{
        return $this->belongsTo(Position::class,'position_id','id');
    }
}
