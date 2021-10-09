<?php
namespace App\Service;

use App\Model\Room;
use App\Model\Message;
use App\Model\ReadStatus;
use App\Model\RoomUser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatService
{
    public static function doSearchRoom($params=[]) {
        $user_id = Auth::user()->id;
        $rooms = ReadStatus::leftJoin(DB::raw("(SELECT chat_room_id, max(id) as read_id FROM `read_statuses` WHERE `receiver_id`={$user_id} group by chat_room_id) as messages"), function ($join) {
                $join->on('messages.read_id', '=', 'read_statuses.id');
            })
            ->where('receiver_id', '=', $user_id)
            ->whereNotNull('messages.read_id')
            ->orderByDesc('id');
        return $rooms;
    }

    public static function getChatRoom($target_id, $type=1) {
        $user_id =  Auth::user()->id;
        $my_room = RoomUser::leftJoin(DB::raw("(SELECT `chat_room_id` as target_room_id, user_id as target_id, user_type as target_type FROM `room_users` WHERE `user_id`={$target_id}) as target_users_room"), function ($join) {
                $join->on('room_users.chat_room_id', '=', 'target_users_room.target_room_id');
            })
            ->where('room_users.user_id', '=', $user_id)
            ->whereNotNull('target_users_room.target_room_id')
            ->first();

        if(is_object($my_room)) {
            return $my_room->chat_room_id;
        } else {
            $new_room = new Room();
            $new_room->chat_type = 1;
            if($new_room->save()) {
                $self_room = new RoomUser();
                $self_room['chat_room_id'] = $new_room->id;
                $self_room['user_id'] = $user_id;
                $self_room['user_type'] = 1;
                $self_room->save();

                $target_room = new RoomUser();
                $target_room['chat_room_id'] = $new_room->id;
                $target_room['user_id'] = $target_id;
                $target_room['user_type'] = 1;
                $target_room->save();

                return $new_room->id;
            } else {
                abort(404);
            }
        }
    }

    public static function getPreviousMessages($room_id, $talker_id = 0, $latest_id=0, $take=20) {
        $criteria = ReadStatus::leftJoin('messages as cm', function ($join) {
            $join->on('cm.id', '=', 'read_statuses.message_id');
        });
        $criteria = $criteria->where ('read_statuses.chat_room_id', '=', $room_id);
        $criteria = $criteria->where ('read_statuses.receiver_id', '=', $talker_id);
        if ($latest_id) {
            $criteria->where ('read_statuses.message_id', '<', $latest_id);
        }
        $criteria->orderByDesc('read_statuses.id');
        $criteria->selectRaw('cm.id as id, cm.message as message, cm.talker_id as talker_id, cm.file_name as file_name, cm.file_path as file_path, read_statuses.status as read_status, read_statuses.created_at as created_at');
        $criteria->take($take);
        if (!$latest_id) {
            self::setReadMark($room_id, $talker_id);
        }
        return $criteria->get()->toArray();
    }

    public static function setMessage($arr_param, $talker_id, $user_type=1) {
        $chat_room_id = $arr_param['chat_room_id'];
        $model = new Message();
        $model->chat_room_id = $chat_room_id;
        if (isset($arr_param['message']) && !empty($arr_param['message'])) {
            $model->message = $arr_param['message'];
        }
        $model->talker_id = $talker_id;
        $model->user_type = $user_type;

        if (isset($arr_param['tmp_file']) && $arr_param['tmp_file']){
            if (Storage::disk('temp')->has($arr_param['tmp_file'])) {
                $file = Storage::disk('temp')->get($arr_param['tmp_file']);
                Storage::disk('chat')->put($chat_room_id . '/' . $arr_param['tmp_file'], $file);
                Storage::disk('temp')->delete($arr_param['tmp_file']);
                $model->file_name = $arr_param['real_file'];
                $model->file_path = $arr_param['tmp_file'];
            }
        }
        if ($model->save()) {
            self::createReadStatusRecords($chat_room_id, $model->id);
            return true;
        }
        return false;
    }

    public static function createReadStatusRecords($room_id, $message_id) {
        $targets = self::getTargetUsers($room_id);

        foreach ($targets as $target) {
            ReadStatus::create([
                'chat_room_id' => $room_id,
                'receiver_id' => $target->user_id,
                'user_type' => $target->user_type,
                'message_id' => $message_id,
                'status' => 0,
            ]);
        }
    }

    //1268069639
    public static function getNewMessages($room_id, $talker_id=0) {
        $criteria = ReadStatus::leftJoin('messages as cm', function ($join) {
            $join->on('cm.id', '=', 'read_statuses.message_id');
        });
        $criteria->where ('read_statuses.chat_room_id', '=', $room_id);
        $criteria->where ('read_statuses.receiver_id', '=', $talker_id);
        $criteria->where ('status',0);
        $criteria->orderByDesc('read_statuses.id');
        $criteria->selectRaw('cm.id as id, cm.message as message, cm.talker_id as talker_id, cm.file_name as file_name, cm.file_path as file_path, read_statuses.status as read_status, read_statuses.created_at as created_at');
        $new_messages = $criteria->get()->toArray();
        if( count($new_messages) > 0) {
            self::setReadMark($room_id, $talker_id);
            return ['messages' => $new_messages];
        } else {
            return [];
        }
    }

    public static function getTargetUsers($room_id) {
       return RoomUser::where('chat_room_id', $room_id)->get();
    }

    public static function getTargetUser($room_id, $me) {
        $target_user =  RoomUser::where('chat_room_id', $room_id)
            ->where('user_id','<>',  $me)
            ->first();
        if(is_object($target_user)) {
            return $target_user->room_user;
        } else {
            return null;
        }
    }

    public static function setReadMark($room_id, $talker_id) {
        return ReadStatus::where('chat_room_id', '=',  $room_id)
            ->where('receiver_id', '=',  $talker_id)
            ->update(['status'=> 1]);
    }



    /*public static function getFirstUnreadMessageID($room_id, $user_id) {
        $first_unread = ReadStatus::where('chat_room_id', $room_id)
            ->where('receiver_id', $user_id)
            ->where('status', config('const.CHAT_READ_STATUS.UNREAD'))
            ->first();
        if (is_object($first_unread)) {
            return $first_unread->message_id;
        } else {
            return 0;
        }
    }

    public static function getChatRoom() {
        $user =  Auth::guard('user')->user();
        $model = Room::where('user_id', $user->id)->first();
        if(is_object($model)) {
            return $model;
        } else {
            $new_model = new Room();
            $new_model->user_id = $user->id;
            $new_model->save();
            return $new_model;
        }
    }

    public static function getChatReadRecord($chat_room_id, $user_id) {
        $chat_read_record = ReadStatus::where('chat_room_id', '=', $chat_room_id)->where('receiver_id', '=', $user_id)->first();
        if ($chat_read_record == null) {
            $new_read_model = new ReadStatus();
            $new_read_model->chat_room_id = $chat_room_id;
            $new_read_model->receiver_id = $user_id;
           if ($new_read_model->save() ){
               return $new_read_model;
           } else {
               return null;
           }
        } else {
            return $chat_read_record;
        }
    }

    public static function getUserChatList($per_page) {
        $user =  Auth::guard('web')->user();

        $chat_rooms = Room::with('user')
            ->where('user_id', '>', 0)
            ->where('user_id', '<>', $user->id)
            ->whereHas('user', function ($query) use ($user){
                $query->where('customer_id', $user->customer->id);
            })
            ->paginate($per_page);

        return $chat_rooms;
    }*/

}