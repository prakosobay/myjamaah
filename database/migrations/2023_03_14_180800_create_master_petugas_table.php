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
        Schema::create('m_petugas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->foreignUuid('created_by')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('updated_by')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_petugas');
    }
};
