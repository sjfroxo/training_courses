<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'chats';
    protected $fillable = ['title', 'slug'];

    public function chatMessages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'chat_id', 'id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'chat_users', 'chat_id', 'user_id')
            ->withPivot('user_role')
            ->withTimestamps();
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function getOtherUserAttribute()
    {
        $currentUserId = auth()->id();
        return $this->users->firstWhere('id', '!=', $currentUserId);
    }

    public function lastMessage(): ?ChatMessage
    {
        $message = $this->chatMessages()->latest()->first();
        if ($message) {
            if ($message->type === 'voice') {
                $message->message = 'Voice message';
            } elseif ($message->type === 'video') {
                $message->message = 'Video message';
            }
        }
        return $message;
    }
}
