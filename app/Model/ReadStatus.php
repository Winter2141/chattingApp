<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Service\ChatService;

class ReadStatus extends Model
{
    use SoftDeletes;

    public $table = 'read_statuses';

    protected $fillable = [
        'chat_room_id',
        'receiver_id',
        'message_id',
        'status',
    ];

    public $primaryKey = 'id';

    public function chat_room()
    {
        return $this->belongsTo('App\Model\Room', 'chat_room_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'receiver_id');
    }

    public function message()
    {
        return $this->belongsTo('App\Model\Message', 'message_id');
    }

    public function target_user()
    {
        $target_user =  ChatService::getTargetUser($this->chat_room_id, $this->receiver_id);
        return $target_user;
    }

    public function unread_messages_count()
    {
        $count =  ReadStatus::selectRaw('count(message_id) as count')
            ->where('chat_room_id', $this->chat_room_id)
            ->where('receiver_id', $this->receiver_id)
            ->where('status', 0)
            ->first();
        return $count->count;
    }
}
