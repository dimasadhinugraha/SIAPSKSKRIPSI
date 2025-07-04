<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LetterType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'required_fields',
        'template',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'required_fields' => 'array',
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function letterRequests()
    {
        return $this->hasMany(LetterRequest::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
