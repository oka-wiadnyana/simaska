<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeputusan extends Model
{
    use HasFactory;
    public $guarded = [];
    public $timestamps = false;
    public $table = 'surat_keputusan';
}
