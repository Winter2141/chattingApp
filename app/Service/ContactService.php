<?php

namespace App\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

use App\Model\Contact;

class ContactService {

    public static function doSearchFront($search_param)
    {
        $contacts = Contact::orderByDesc('created_at')
            ->where('reciever_id', auth()->id());

        if(isset($search_param['search_name']))
        {
            $contacts = $contacts->where('name', 'LIKE', '%'.$search_param['search_name'].'%');
        }

        $contacts = $contacts->where(function($q){
            $q->where('status', 1)
                ->orWhere('status', 4);
        });
        return $contacts;
    }

    public static function doCreate($id)
    {
        $contact = [];
        $contact['contact_kind'] = 1;

        $contact['is_sender'] = 1;
        $contact['status'] = 1;
        $contact['contact_date_time'] = Carbon::now();
        $contact['sender_id'] = auth()->id();
        $contact['reciever_id'] = $id;
        $new_contact = Contact::create($contact);

        if($new_contact->save()) {
            return true;
        }
        return false;
    }

    public static function getContactStatus($id)
    {
        $contact = Contact::where('sender_id', $id)
            ->where('reciever_id', auth()->id())
            ->first();
        return $contact->status;
    }

    public static function doAccept($id)
    {
        $contact = Contact::where('sender_id', $id)->where('reciever_id', auth()->id())->first();
        $contact->status = 4;
        
        $my_contact = new Contact();
        $my_contact->contact_kind =1;
        $my_contact->sender_id = auth()->id();
        $my_contact->reciever_id = $id;
        $my_contact->contact_date_time = Carbon::now();
        $my_contact->is_sender = 2;
        $my_contact->status = 4;

        if($contact->save() && $my_contact->save()) {
            return true;
        }
        return false;
    }

    public static function doReject($id)
    {
        $contact = Contact::where('sender_id', $id)->where('reciever_id', auth()->id())->first();
        $contact->status = 3;

        if($contact->save()) {
            return true;
        }
        return false;
    }
}