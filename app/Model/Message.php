<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    public $table = 'messages';

    protected $fillable = [
        'chat_room_id',
        'message',
        'talker_id',
        'file_name',
        'file_path',
        'user_type'
    ];

    protected $hidden = ['deleted_at'];

    public $primaryKey = 'id';

    public function chat_room()
    {
        return $this->belongsTo('App\Model\Room', 'chat_room_id');
    }

    public function talker()
    {
        return $this->belongsTo('App\User', 'talker_id');
    }
}
