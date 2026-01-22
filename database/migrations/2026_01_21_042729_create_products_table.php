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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
             $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('amount', 10, 2);
            $table->string( "color");
            $table->unsignedBigInteger("stock_id");
            $table->foreign('stock_id')->references('id')->on('stocks')->onDelete('cascade');   
            $table->unsignedBigInteger('creater_id');
            $table->foreign('creater_id')->references('id')->on('users')->onDelete('cascade');  
            $table->unsignedBigInteger('group_category_id');
            $table->foreign('group_category_id')->references('id')->on('group_categories')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
