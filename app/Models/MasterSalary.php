<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class MasterSalary extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    protected $table = 'm_salaries';
    protected $fillable = [
        'range',
        'created_by',
        'updated_by',
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
