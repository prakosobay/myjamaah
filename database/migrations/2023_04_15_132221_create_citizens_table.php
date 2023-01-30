<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citizens', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('m_job_id')->constrained('m_jobs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('m_salary_id')->constrained('m_salaries')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('m_religion_id')->constrained('m_religions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('m_family_status_id')->constrained('m_family_statuses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('m_education_id')->constrained('m_educations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('m_residence_status_id')->constrained('m_residence_statuses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('m_social_status_id')->constrained('m_social_statuses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('created_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('updated_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedSmallInteger('rt');
            $table->unsignedSmallInteger('rw');
            $table->string('kk_number')->unique();
            $table->string('nik_number')->unique();
            $table->string('name');
            $table->date('birthday');
            $table->string('gender');
            $table->string('street');
            $table->tinyInteger('house_number');
            $table->string('phone')->unique();
            $table->string('marriage_status');
            $table->boolean('is_death')->nullable();
            $table->date('death_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('citizens');
    }
};
