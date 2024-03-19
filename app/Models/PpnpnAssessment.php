<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class PpnpnAssessment extends Model
{
    use HasFactory;
    public $table="table_ppnpn_assessment";
    public $guarded=[];

    public function dataPpnpn():BelongsTo
    {
        return $this->belongsTo(Employee::class,'ppnpn_id','id');
    }

    public function unitPpnpn():HasOneThrough
    {
        return $this->hasOneThrough(Unit::class,Employee::class,'id','id','ppnpn_id','unit_id');
    }
    public function positionPpnpn():HasOneThrough
    {
        return $this->hasOneThrough(Position::class,Employee::class,'id','id','ppnpn_id','position_id');
    }
}
