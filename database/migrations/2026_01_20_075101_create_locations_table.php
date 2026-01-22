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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('country');
            $table->string('province');
            $table->string('district');
            $table->string('village');
            $table->string('zoon');
            $table->string('state');
            // $table->unsignedBigInteger('creater_id');
            // $table->foreign('creater_id')->references('id')->on('users')->onDelete('cascade');  
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
