<?php

namespace App\Models;

use App\Trait\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Transaction extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    protected $table = 'transactions';
    protected $fillable = [
        'name',
        'date_trans',
        'type',
        'val',
        'created_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
