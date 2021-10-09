<?php

namespace App\Service;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


use App\User;
use App\Model\Contact;

class UserService {

    public static function doCreate($input_param)
    {
        $input_param['password'] = Hash::make($input_param['password']);
        $user = User::create($input_param);

        if($user->save())
        {
            if(isset($input_param['avatar']) && Storage::disk('temp')->has($input_param['avatar'])) {
                $file = Storage::disk('temp')->get($input_param['avatar']);
                Storage::disk('users')->put($user->id.'/'.$input_param['avatar'], $file);
                Storage::disk('temp')->delete($input_param['avatar']);
            }
            return true;
        } else {
            return false;
        }
    }

    public static function doSearchForContact($search_param)
    {
        $contacts = User::orderBy('id');
        $receiver_ids = Contact::where('sender_id', auth()->id())->where('status', '<>', 3)->get();

        foreach ($receiver_ids as $key => $receiver_id) {
            $contacts = $contacts->where('id', '<>', $receiver_id->reciever_id);    
        }

        $contacts = $contacts->where(function($query){
            $query->where('id', '<>' ,auth()->id());
        });
        
        if(isset($search_param['search_by_name']) && $search_param['search_by_name'])
        {
            $contacts = $contacts->where(function($query) use($search_param) {
                    $query->where('name', 'like' ,'%'.$search_param['search_by_name'].'%');
            });
        }
        return $contacts;
    }

}