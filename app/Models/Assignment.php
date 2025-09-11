<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = ['supervisor_id', 'technician_id', 'line_id', 'shift', 'status', 'assigned_at', 'due_at', 'notes'];

    protected $casts = ['assigned_at' => 'datetime', 'due_at' => 'datetime'];

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function technician()
    {
        return $this->belongsTo(Employee::class, 'technician_id');
    }

    public function line()
    {
        return $this->belongsTo(ProductionLine::class, 'line_id');
    }

    public function tools()
    {
        return $this->belongsToMany(Tool::class, 'assignment_tools')->withTimestamps();
    }

    public function audits()
    {
        return $this->hasMany(Audit::class, 'assignment_id');
    }
}
