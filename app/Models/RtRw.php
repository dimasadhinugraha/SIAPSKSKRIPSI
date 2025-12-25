<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RtRw extends Model
{
    use HasFactory;

    protected $table = 'rt_rw';

    protected $fillable = [
        'rt',
        'rw',
        'user_id',
    ];

    public function getRtRwFormatAttribute()
    {
        if ($this->rt == 0) {
            return sprintf('RW %03d', $this->rw);
        }
        return sprintf('%03d/%03d', $this->rt, $this->rw);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function users()
    {
        return $this->hasMany(\App\Models\User::class, ['rt', 'rw'], ['rt', 'rw']);
    }
}
