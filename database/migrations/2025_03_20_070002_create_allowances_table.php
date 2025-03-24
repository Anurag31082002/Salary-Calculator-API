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
        Schema::create('allowances', function (Blueprint $table) {
            $table->id(); // Primary key
        
            // Foreign key for employee_id
            $table->foreignId('employee_id')
                  ->constrained('employees')
                  ->onDelete('cascade'); 
            $table->decimal('hra', 10, 2)->nullable(); 
            $table->decimal('da', 10, 2)->nullable(); 
            $table->decimal('ta', 10, 2)->nullable();  
            $table->decimal('additional_allowance', 10, 2)->nullable();  
            $table->timestamps();
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allowances');
    }
};
