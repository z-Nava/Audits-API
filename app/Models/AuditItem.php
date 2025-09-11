<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditItem extends Model
{
    use HasFactory;

    protected $fillable = ['audit_id', 'tool_id', 'status', 'comments', 'defects'];

    protected $casts = ['defects' => 'array'];

    public function audit()
    {
        return $this->belongsTo(Audit::class, 'audit_id');
    }

    public function tool()
    {
        return $this->belongsTo(Tool::class, 'tool_id');
    }

    public function photos()
    {
        return $this->hasMany(AuditPhoto::class, 'audit_item_id');
    }
}
