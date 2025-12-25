<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        // 'name', // Moved to users table
        // 'nik', // Moved to users table
        'kk_number',
        'gender',
        'agama',
        'birth_date',
        'address',
        'phone',
        'rt_rw',
        'rt_id',
        'rw_id',
        'is_verified',
        'verified_at',
        'verified_by',
        'ktp_photo',
        'kk_photo',
        'profile_photo',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'verified_at' => 'datetime',
    ];

    /**
     * Get the user that owns the biodata.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the RT user associated with this biodata.
     */
    public function rt()
    {
        return $this->belongsTo(User::class, 'rt_id');
    }

    /**
     * Get the RW user associated with this biodata.
     */
    public function rw()
    {
        return $this->belongsTo(User::class, 'rw_id');
    }

    /**
     * Get the user who verified this biodata.
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
