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
        Schema::create('schedulings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('date');
            $table->tinyInteger('class_number');
            $table->varchar('Shift');

            $table->unsignedBigInteger('place_id');  //chave estrangeira
            $table->foreign('place_id')->references('id')->on('places');  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedulings');
    }
};
