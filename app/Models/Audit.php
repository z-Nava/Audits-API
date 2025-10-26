<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id','technician_id','supervisor_id',
        'employee_number','audit_code','line_id','shift',
        'status','summary','overall_result','started_at','ended_at'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function line()
    {
        return $this->belongsTo(ProductionLine::class, 'line_id');
    }

    public function items()
    {
        return $this->hasMany(AuditItem::class, 'audit_id');
    }

    public function reviews()
    {
        return $this->hasMany(AuditReview::class, 'audit_id');
    }
}
