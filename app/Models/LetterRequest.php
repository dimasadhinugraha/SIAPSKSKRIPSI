<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LetterRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_number',
        'user_id',
        'subject_type',
        'subject_id',
        'letter_type_id',
        'form_data',
        'status',
        'rejection_reason',
        'submitted_at',
        'rt_processed_at',
        'rw_processed_at',
        'final_processed_at',
    ];

    protected function casts(): array
    {
        return [
            'form_data' => 'array',
            'submitted_at' => 'datetime',
            'rt_processed_at' => 'datetime',
            'rw_processed_at' => 'datetime',
            'final_processed_at' => 'datetime',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function letterType()
    {
        return $this->belongsTo(LetterType::class);
    }

    public function approvals()
    {
        return $this->hasMany(LetterApproval::class);
    }

    public function subject()
    {
        return $this->belongsTo(FamilyMember::class, 'subject_id');
    }

    // Helper methods
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending_rt' => 'Menunggu Persetujuan RT',
            'approved_rt' => 'Disetujui RT',
            'rejected_rt' => 'Ditolak RT',
            'pending_rw' => 'Menunggu Persetujuan RW',
            'approved_rw' => 'Disetujui RW',
            'rejected_rw' => 'Ditolak RW',
            'approved_final' => 'Surat Selesai',
            'rejected_final' => 'Ditolak Final',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    public function isApproved()
    {
        return $this->status === 'approved_final';
    }

    public function isRejected()
    {
        return in_array($this->status, ['rejected_rt', 'rejected_rw', 'rejected_final']);
    }

    public function isPending()
    {
        return in_array($this->status, ['pending_rt', 'pending_rw']);
    }

    public function getSubjectNameAttribute()
    {
        if ($this->subject_type === 'self') {
            return $this->user->name;
        } elseif ($this->subject_type === 'family_member' && $this->subject) {
            return $this->subject->name;
        }

        return 'Tidak diketahui';
    }

    public function getSubjectNikAttribute()
    {
        if ($this->subject_type === 'self') {
            return $this->user->nik;
        } elseif ($this->subject_type === 'family_member' && $this->subject) {
            return $this->subject->nik;
        }

        return 'Tidak diketahui';
    }

    public function getSubjectDetailsAttribute()
    {
        if ($this->subject_type === 'self') {
            return [
                'name' => $this->user->name,
                'nik' => $this->user->nik,
                'gender' => $this->user->gender,
                'birth_date' => $this->user->birth_date,
                'address' => $this->user->address,
                'phone' => $this->user->phone,
                'relationship' => 'Pemohon'
            ];
        } elseif ($this->subject_type === 'family_member' && $this->subject) {
            return [
                'name' => $this->subject->name,
                'nik' => $this->subject->nik,
                'gender' => $this->subject->gender,
                'birth_date' => $this->subject->date_of_birth,
                'address' => $this->user->address, // Alamat sama dengan kepala keluarga
                'phone' => $this->user->phone, // Phone sama dengan kepala keluarga
                'relationship' => $this->subject->relationship_label
            ];
        }

        return null;
    }

    // Scopes
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePendingRT($query)
    {
        return $query->where('status', 'pending_rt');
    }

    public function scopePendingRW($query)
    {
        return $query->where('status', 'pending_rw');
    }
}
