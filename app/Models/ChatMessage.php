<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class ChatMessage extends Model
{
    use HasFactory;

    protected $table = 'chat_messages';
    protected $fillable = [
        'message',
        'user_id',
        'chat_id',
        'type',
        'reply_message_id',
        'media_url',
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function repliedToMessage(): BelongsTo
    {
        return $this->belongsTo(ChatMessage::class, 'reply_message_id');
    }

    public function getFormattedTimeAttribute(): string
    {
        $createdAt = $this->created_at;
        $now = Carbon::now();

        if ($createdAt->isToday()) {
            return $createdAt->format('H:i');
        } elseif ($createdAt->greaterThanOrEqualTo($now->copy()->startOfWeek())) {
            return $createdAt->translatedFormat('l');
        } else {
            return $createdAt->format('d/m/Y');
        }
    }
}
