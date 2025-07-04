<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LetterApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_request_id',
        'approved_by',
        'approval_level',
        'status',
        'notes',
        'processed_at',
    ];

    protected function casts(): array
    {
        return [
            'processed_at' => 'datetime',
        ];
    }

    // Relationships
    public function letterRequest()
    {
        return $this->belongsTo(LetterRequest::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Helper methods
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    // Scopes
    public function scopeByLevel($query, $level)
    {
        return $query->where('approval_level', $level);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
