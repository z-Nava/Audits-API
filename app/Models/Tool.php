<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    use HasFactory;

    protected $fillable = ['code','name', 'model', 'description', 'line_id', 'active'];

    protected $casts = ['active' => 'boolean'];

    public function line()
    {
        return $this->belongsTo(ProductionLine::class, 'line_id');
    }

    public function assignments()
    {
        return $this->belongsToMany(Assignment::class, 'assignment_tools')->withTimestamps();
    }

    public function auditItems()
    {
        return $this->hasMany(AuditItem::class, 'tool_id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
