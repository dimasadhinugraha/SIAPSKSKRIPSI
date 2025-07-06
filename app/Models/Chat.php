<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'created_by',
        'participants',
        'is_active',
        'last_message_at',
    ];

    protected function casts(): array
    {
        return [
            'participants' => 'array',
            'last_message_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class)->orderBy('created_at', 'asc');
    }

    public function latestMessage()
    {
        return $this->hasOne(ChatMessage::class)->latestOfMany();
    }

    public function unreadMessages()
    {
        return $this->hasMany(ChatMessage::class)->where('is_read', false);
    }

    // Helper methods
    public function isParticipant($userId)
    {
        return in_array($userId, $this->participants ?? []);
    }

    public function addParticipant($userId)
    {
        $participants = $this->participants ?? [];
        if (!in_array($userId, $participants)) {
            $participants[] = $userId;
            $this->update(['participants' => $participants]);
        }
    }

    public function removeParticipant($userId)
    {
        $participants = $this->participants ?? [];
        $participants = array_filter($participants, fn($id) => $id != $userId);
        $this->update(['participants' => array_values($participants)]);
    }

    public function getParticipantUsers()
    {
        return User::whereIn('id', $this->participants ?? [])->get();
    }

    public function getUnreadCount($userId)
    {
        return $this->messages()
                   ->where('user_id', '!=', $userId)
                   ->where('is_read', false)
                   ->count();
    }

    public function markAsRead($userId)
    {
        $this->messages()
             ->where('user_id', '!=', $userId)
             ->where('is_read', false)
             ->update([
                 'is_read' => true,
                 'read_at' => now()
             ]);
    }

    // Scopes
    public function scopeForUser($query, $userId)
    {
        return $query->whereJsonContains('participants', $userId);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Static methods
    public static function createPrivateChat($user1Id, $user2Id, $title = null)
    {
        // Check if private chat already exists
        $existingChat = self::where('type', 'private')
            ->whereJsonContains('participants', $user1Id)
            ->whereJsonContains('participants', $user2Id)
            ->first();

        if ($existingChat) {
            return $existingChat;
        }

        $user1 = User::find($user1Id);
        $user2 = User::find($user2Id);

        return self::create([
            'title' => $title ?: "Chat dengan {$user2->name}",
            'type' => 'private',
            'created_by' => $user1Id,
            'participants' => [$user1Id, $user2Id],
        ]);
    }

    // Helper method to get chat title for current user
    public function getTitleForUser($userId)
    {
        if ($this->type === 'private') {
            // For private chat, show the other participant's name
            $otherParticipantId = collect($this->participants)->first(fn($id) => $id != $userId);
            if ($otherParticipantId) {
                $otherUser = User::find($otherParticipantId);
                return $otherUser ? $otherUser->name : $this->title;
            }
        }

        return $this->title;
    }

    public static function createGroupChat($creatorId, $participantIds, $title)
    {
        $participants = array_unique(array_merge([$creatorId], $participantIds));

        return self::create([
            'title' => $title,
            'type' => 'group',
            'created_by' => $creatorId,
            'participants' => $participants,
        ]);
    }

    public static function createAnnouncementChat($creatorId, $title)
    {
        // For announcements, initially only creator is participant
        // Others will be added when they join
        return self::create([
            'title' => $title,
            'type' => 'announcement',
            'created_by' => $creatorId,
            'participants' => [$creatorId],
        ]);
    }
}
