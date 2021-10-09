<?php

namespace App\Http\Controllers\Share;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Service\ChatService;
use App\Model\Message;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public $platform;
    public $talker_id;

    public function getMessages(Request $request) {
        $previous_messages = [];
        $new_messages = [];
        if ($request->get_method == 'old') {
            $previous_messages = ChatService::getPreviousMessages($request->id, $this->talker_id, $request->latest_id);
        } else {
            $new_messages = ChatService::getNewMessages($request->id, $this->talker_id);
        }
        return response()->json(['previous_messages'=>$previous_messages, 'new_messages' => $new_messages]);
    }

    public function sendMessage(Request $request)
    {
        $result = [];
        if($request->has('chat_room_id')) {
            $model = ChatService::setMessage($request->all(), $this->talker_id);
            if($model) {
                $result['result_code'] = 'success';
                $result['new_messages'] =ChatService::getNewMessages($request->input('chat_room_id'), $this->talker_id);
                return response()->json($result);
            }
        }
        $result['result_code'] = 'fail';
        return response()->json($result);
    }

    public function ajaxFileUpload(Request $request) {
        $download_file = $request->file('vfile');
        $new_filename = Str::random(40).'.'. $download_file->getClientOriginalExtension();
        $path = $request->file('vfile')->storeAs('public/temp', $new_filename);
        die($new_filename) ;
    }

    public function download($id) {
        $model = ChatMessages::find($id);
        $download_file = storage_path("app/chat/{$model->chat_room_id}/{$model->file_path}");
        return response()->download( $download_file, $model->file_name);
    }

    public function deleteFile(Request $request) {
        if ($request->has('tmp_file')) {
            Storage::disk('temp')->delete($request->tmp_file);
            return response()->json(['result'=>'success']);
        } else {
            return response()->json(['result'=>'fail']);
        }
    }

}
