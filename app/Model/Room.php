<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;

    public $table = 'rooms';

    protected $fillable = [
        'chat_type',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public $primaryKey = 'id';

    public function reads()
    {
        return $this->hasMany('App\Model\ReadStatus', 'chat_room_id' );
    }
}
