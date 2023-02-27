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
        Schema::create('saldo_kas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('duit');
            $table->string('note');
            $table->boolean('is_income')->nullable();
            $table->foreignUuid('updated_by')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('saldo_kas');
    }
};
