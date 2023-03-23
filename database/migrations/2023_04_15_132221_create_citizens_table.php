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
            $table->foreignUuid('m_job_id')->nullable()->constrained('m_jobs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('m_salary_id')->nullable()->constrained('m_salaries')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('m_religion_id')->nullable()->constrained('m_religions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('m_family_status_id')->nullable()->constrained('m_family_statuses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('m_education_id')->nullable()->constrained('m_educations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('m_residence_status_id')->nullable()->constrained('m_residence_statuses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('m_social_status_id')->nullable()->constrained('m_social_statuses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('created_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('updated_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedSmallInteger('rt')->nullable();
            $table->unsignedSmallInteger('rw')->nullable();
            $table->string('kk_number')->nullable();
            $table->string('nik_number')->unique();
            $table->string('name')->nullable();
            $table->date('birthday')->nullable();
            $table->string('gender')->nullable();
            $table->string('street')->nullable();
            $table->smallInteger('house_number')->nullable();
            $table->string('phone')->nullable();
            $table->string('marriage_status')->nullable();
            $table->boolean('is_death')->nullable();
            $table->date('death_date')->nullable();
            $table->string('ket')->nullable();
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
