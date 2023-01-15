<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Citizen extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    protected $table = 'citizens';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kk_number',
        'nik_number',
        'name',
        'birthday',
        'gender',
        'street',
        'rt',
        'rw',
        'house_number',
        'phone',
        'age',
        'marriage_status',
        'm_job_id',
        'm_salary_id',
        'm_religion_id',
        'm_family_status_id',
        'm_education_id',
        'm_residence_status_id',
        'm_social_status_id',
        'is_death',
        'death_date',
    ];

}
