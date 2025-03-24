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
        Schema::create('deductions', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('employee_id')
                  ->constrained('employees')
                  ->onDelete('cascade');
                  $table->decimal('pf', 10, 2)->nullable();
                  $table->decimal('health_insurance', 10, 2)->nullable();
                  $table->decimal('other_deductions', 10, 2)->nullable();
      
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deductions');
    }
};
