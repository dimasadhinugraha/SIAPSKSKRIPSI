<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
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
        'nik',
        'email',
        'password',
        'role',
        'rt',
        'rw',
        'address',
        'phone',
        'is_verified',
        'is_approved',
        'email_verified_at',
        'family_id',
        'is_head_of_family',
    ];

    /**
     * The biodata associated with the user.
     */
    public function biodata()
    {
        return $this->hasOne(Biodata::class);
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'nik'; // Keep NIK for authentication
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getAttribute('nik'); // Keep NIK for authentication
    }

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

    /**
     * Get the biodatas that this user has verified.
     */
    public function verifiedBiodatas()
    {
        return $this->hasMany(Biodata::class, 'verified_by');
    }

    public function familyMembers()
    {
        // This might need adjustment if it relies on biodata fields.
        // For now, assuming it's based on user_id which is fine.
        return $this->hasMany(FamilyMember::class);
    }

    public function activeFamilyMembers()
    {
        return $this->hasMany(FamilyMember::class)->where('is_active', true);
    }

    /**
     * Get the family this user belongs to
     */
    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    /**
     * Get other family members (excluding self)
     */
    public function siblings()
    {
        return $this->hasMany(User::class, 'family_id', 'family_id')
                    ->where('id', '!=', $this->id);
    }

    public function approvedFamilyMembers()
    {
        return $this->hasMany(FamilyMember::class)
            ->where('is_active', true)
            ->where('approval_status', 'approved');
    }

    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'chat_participants', 'user_id', 'chat_id');
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function createdChats()
    {
        return $this->hasMany(Chat::class, 'created_by');
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

    public function getInitialsAttribute()
    {
        return strtoupper(substr($this->name, 0, 2));
    }

    public function getRoleLabelAttribute()
    {
        $roles = [
            'admin' => 'Administrator',
            'rt' => 'Ketua RT',
            'rw' => 'Ketua RW',
            'user' => 'Warga'
        ];

        return $roles[$this->role] ?? 'Unknown';
    }

    public function getRtRwAttribute()
    {
        if ($this->rt && $this->rw) {
            return "RT {$this->rt} / RW {$this->rw}";
        } elseif ($this->rw) {
            return "RW {$this->rw}";
        }
        return '-';
    }
}
