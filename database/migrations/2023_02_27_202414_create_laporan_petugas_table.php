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
        Schema::create('laporan_petugas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('m_petugas_id')->constrained('m_petugas')->onUpdate('cascade')->onDelete('cascade');
            $table->string('duty');
            $table->unsignedBigInteger('nominal');
            $table->date('date');
            $table->string('status');
            $table->foreignUuid('created_by')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('laporan_petugas');
    }
};
