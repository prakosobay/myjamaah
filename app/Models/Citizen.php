<?php

namespace App\Models;

use App\Trait\Uuid;
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

    public function mJobId()
    {
        return $this->belongsTo(MasterJob::class, 'm_job_id');
    }

    public function mSalaryId()
    {
        return $this->belongsTo(MasterSalary::class, 'm_salary_id');
    }

    public function mReligionId()
    {
        return $this->belongsTo(MasterReligion::class, 'm_religion_id');
    }

    public function mFamilyStatusId()
    {
        return $this->belongsTo(MasterFamilyStatus::class, 'm_family_status_id');
    }

    public function mEducationId()
    {
        return $this->belongsTo(MasterEducation::class, 'm_education_id');
    }

    public function mResidenceStatusId()
    {
        return $this->belongsTo(MasterResidenceStatus::class, 'm_residence_status_id');
    }

    public function mSocialStatusId()
    {
        return $this->belongsTo(MasterSocialStatus::class, 'm_social_status_id');
    }

}
