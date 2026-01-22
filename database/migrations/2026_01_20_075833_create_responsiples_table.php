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
        Schema::create('responsiples', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('gender');
            $table->integer('phone');
            // $table->unsignedBigInteger("countable_id");
            // $table->foreign('countable_id')->references('id')->on('countables')->onDelete('cascade');
            // $table->unsignedBigInteger("user_id");
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->unsignedBigInteger("stock_id");
            // $table->foreign('stock_id')->references('id')->on('stocks')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responsiples');
    }
};
