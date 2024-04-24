<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeFinanceMovement extends Model
{
    use HasFactory;

    protected $casts = [
        'date' => 'datetime'
    ];

    protected $fillable = [
        'employee_id',
        'description',
        'amount',
        'date'
    ];
}
