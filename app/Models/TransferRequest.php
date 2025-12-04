<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_member_id',
        'requested_by',
        'to_address',
        'to_kk_number',
        'reason',
        'supporting_document',
        'status',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
