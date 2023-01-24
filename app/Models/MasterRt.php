<?php

namespace App\Models;

use App\Trait\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class MasterRt extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    protected $table = 'm_rts';
    protected $fillable = [
        'number',
        'm_rw_id',
        'created_by',
        'updated_by',
    ];

    public function mRwId()
    {
        return $this->belongsTo(MasterRw::class, 'm_rw_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
