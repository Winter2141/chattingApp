<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomUser extends Model
{
    use SoftDeletes;

    public $table = 'room_users';

    protected $fillable = [
        'chat_room_id',
        'user_id',
        'user_type',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public $primaryKey = 'id';

    public function room_user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
