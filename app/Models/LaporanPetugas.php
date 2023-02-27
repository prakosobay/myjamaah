<?php

namespace App\Models;

use App\Trait\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class LaporanPetugas extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    protected $table = 'laporan_petugas';
    protected $fillable = [
        'name',
        'duty',
        'nominal',
        'created_by',
        'date',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
