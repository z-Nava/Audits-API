<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionLine extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'area', 'active'];

    protected $casts = ['active' => 'boolean'];

    public function tools()
    {
        return $this->hasMany(Tool::class, 'line_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'line_id');
    }

    public function audits()
    {
        return $this->hasMany(Audit::class, 'line_id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
