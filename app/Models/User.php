<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nik',
        'gender',
        'birth_date',
        'address',
        'phone',
        'kk_number',
        'ktp_photo',
        'kk_photo',
        'role',
        'rt_rw',
        'is_verified',
        'verified_at',
        'verified_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
            'is_verified' => 'boolean',
            'verified_at' => 'datetime',
        ];
    }

    // Relationships
    public function letterRequests()
    {
        return $this->hasMany(LetterRequest::class);
    }

    public function letterApprovals()
    {
        return $this->hasMany(LetterApproval::class, 'approved_by');
    }

    public function news()
    {
        return $this->hasMany(News::class, 'author_id');
    }

    public function verifiedUsers()
    {
        return $this->hasMany(User::class, 'verified_by');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function activeFamilyMembers()
    {
        return $this->hasMany(FamilyMember::class)->where('is_active', true);
    }

    public function approvedFamilyMembers()
    {
        return $this->hasMany(FamilyMember::class)->where('is_active', true)->where('approval_status', 'approved');
    }

    public function pendingFamilyMembers()
    {
        return $this->hasMany(FamilyMember::class)->where('is_active', true)->where('approval_status', 'pending');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isRT()
    {
        return $this->role === 'rt';
    }

    public function isRW()
    {
        return $this->role === 'rw';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function canApproveLetters()
    {
        return in_array($this->role, ['rt', 'rw', 'admin']);
    }
}
