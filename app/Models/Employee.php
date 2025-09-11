<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_number','name','registered_by','active'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function registeredBy()
    {
        return $this->belongsTo(User::class, 'registered_by');
    }
}
