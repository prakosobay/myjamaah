<?php

namespace App\Models;

use App\Trait\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class MasterKawasan extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    protected $table = 'm_kawasans';
    protected $fillable = [
        'rt',
        'rw',
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
