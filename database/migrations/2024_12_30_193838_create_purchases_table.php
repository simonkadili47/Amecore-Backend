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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id('purchase_id');
            $table->string('items');
            $table->integer('quantity');
            $table->decimal('amount', 10, 2);
            $table->date('date');
            $table->unsignedBigInteger('user_id'); // Reference to users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Corrected reference to 'id'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
