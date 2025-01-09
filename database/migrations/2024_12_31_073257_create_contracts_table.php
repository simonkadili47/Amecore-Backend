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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id('contract_id'); 
            $table->string('customer_name');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('item');
            $table->unsignedBigInteger('project_id'); 
            
          
            $table->foreign('project_id')
                ->references('id') 
                ->on('projects')
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
        Schema::dropIfExists('contracts');
    }
};
