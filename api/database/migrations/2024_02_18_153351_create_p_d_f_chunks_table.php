<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('p_d_f_chunks', function (Blueprint $table) {
            $table->id();
            $table->integer('p_d_f_contents_id');
            $table->json('block_data');
            $table->string('text')->nullable();
            $table->string('block_type');
            $table->float('confidence');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_d_f_chunks');
    }
};
