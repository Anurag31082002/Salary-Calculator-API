<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'basic_salary'
    ];

    public function allowances()
    {
        return $this->hasMany(Allowance::class);
    }

    public function deductions()
    {
        return $this->hasMany(Deduction::class);
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
