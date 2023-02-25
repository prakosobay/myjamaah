<?php

namespace App\Models;

use App\Trait\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class SaldoKas extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    protected $table = 'saldo_kas';
    protected $fillable = [
        'duit',
        'note',
        'is_income',
        'updated_by',
        'created_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
