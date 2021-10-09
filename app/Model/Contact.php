<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'contact_kind',
        'contact_date_time',
        'sender_id',
        'reciever_id',
        'is_sender',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'reciever_id');
    }

    public function send_user()
    {
        return $this->belongsTo('App\User', 'sender_id');
    }
}
