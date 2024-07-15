<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'ch_messages';

    protected $fillable = ['from_id','to_id','body','seen'];

    public function user()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    public static function getChatUsers()
    {
        $userId = auth()->user()->id;

        $fromUsers = self::where('from_id', $userId)->distinct()->pluck('to_id')->toArray();
        $toUsers = self::where('to_id', $userId)->distinct()->pluck('from_id')->toArray();
        $chatUserIds = array_unique(array_merge($fromUsers, $toUsers));
        $latestMessages = [];
        foreach ($chatUserIds as $otherUserId) {
            $message = self::where(function ($query) use ($userId, $otherUserId) {
                $query->where('from_id', $userId)
                    ->where('to_id', $otherUserId);
            })->orWhere(function ($query) use ($userId, $otherUserId) {
                $query->where('from_id', $otherUserId)
                    ->where('to_id', $userId);
            })->latest()->first();

            if ($message) {
                $latestMessages[$otherUserId] = $message;
            }
        }
        $chatUsers = User::whereIn('id', $chatUserIds)->get();
        foreach ($chatUsers as $user) {
            if (isset($latestMessages[$user->id])) {
                $user->latest_message = $latestMessages[$user->id]->body;
                $user->latest_message_time = $latestMessages[$user->id]->created_at;
            } else {
                $user->latest_message = null;
                $user->latest_message_time = null;
            }
        }

        return $chatUsers;
    }

    public static function unseenCount($userId)
    {
        return self::where('to_id', $userId)
                    ->where('seen', 0)
                    ->count();
    }
}
