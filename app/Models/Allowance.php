<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'hra',
        'da',
        'ta',
        'additional_allowance',
    ];

 
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
