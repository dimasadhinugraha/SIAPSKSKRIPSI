<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'user_id',
        'message',
        'type',
        'file_path',
        'file_name',
        'is_read',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'read_at' => 'datetime',
        ];
    }

    // Relationships
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper methods
    public function isText()
    {
        return $this->type === 'text';
    }

    public function isFile()
    {
        return $this->type === 'file';
    }

    public function isImage()
    {
        return $this->type === 'image';
    }

    public function getFileUrl()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }

    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now()
            ]);
        }
    }

    // Boot method to update chat's last_message_at
    protected static function boot()
    {
        parent::boot();

        static::created(function ($message) {
            $message->chat->update(['last_message_at' => $message->created_at]);
        });
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
