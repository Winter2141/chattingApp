<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Share\ChatController;
use App\Service\ChatService;
use Illuminate\Support\Facades\Auth;

class UserChatController extends ChatController
{
    public $per_page = 10;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->talker_id = Auth::user()->id;
            $this->platform = 'user';
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $rooms = ChatService::doSearchRoom()->paginate($this->per_page);
        return view('chat.index', compact('rooms'));
    }

    public function room(Request $request) {
        if($request->has('room_id')) {
            $room_id = $request->input('room_id');
        } elseif ($request->has('target_id')) {
            $target_user_id = $request->input('target_id');
            $room_id = ChatService::getChatRoom($target_user_id);
            return redirect()->route("chat.room", ['room_id'=>$room_id]);
        } else {
            abort(404);
        }

        $target_user =ChatService::getTargetUser($room_id, $this->talker_id);
        return view('chat.room', [
            'platform' =>$this->platform,
            'target_user' => $target_user,
            'room_id'=>$room_id,
            'user_id'=>$this->talker_id,
            'user_type'=>1,
            'display_back_btn' => true
        ]);
    }
}
