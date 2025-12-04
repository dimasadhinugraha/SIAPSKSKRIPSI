<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Family extends Model
{
    protected $fillable = [
        'family_name',
        'kk_number',
        'address',
        'rt',
        'rw',
        'head_of_family_id',
    ];

    /**
     * Get all users in this family
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the head of family
     */
    public function headOfFamily(): BelongsTo
    {
        return $this->belongsTo(User::class, 'head_of_family_id');
    }

    /**
     * Get family members excluding head of family
     */
    public function members(): HasMany
    {
        return $this->hasMany(User::class)->where('is_head_of_family', false);
    }

    /**
     * Get formatted RT/RW
     */
    public function getRtRwAttribute()
    {
        return $this->rt && $this->rw ? "RT {$this->rt}/RW {$this->rw}" : '-';
    }
}
