<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'pf',
        'health_insurance',
        'other_deductions',
    ];
    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
