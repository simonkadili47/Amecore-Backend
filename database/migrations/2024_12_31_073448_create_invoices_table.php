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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id('invoice_id');
            $table->string('invoice_name');
            $table->string('invoice_number');
            $table->decimal('amount', 10, 2);
            $table->date('due_date');
            $table->string('status');
            $table->unsignedBigInteger('contract_id');  
            
            // Foreign key reference
            $table->foreign('contract_id')
                ->references('contract_id') 
                ->on('contracts')
                ->onDelete('cascade');
            
            $table->timestamps();

            
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
