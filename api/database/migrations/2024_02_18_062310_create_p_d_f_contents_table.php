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
        //With only a few hours and AWS being the focus, I just want to show that I know how to save data.
        Schema::create('p_d_f_contents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('pages');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_d_f_contents');
    }
};
