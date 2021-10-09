@extends('layouts.main')

@section('header')
    <div id="header">
        <h1 class="maintitle">Chat</h1>
    </div>
@endsection

@section('content')
    <div id="talk-people-wrap" class="fixclear">
        <ul class="talk-box">
            @foreach($rooms as $room)
                <li>
                    <a href="{{ route('chat.room', ['room_id' => $room->chat_room_id]) }}#last">
                        <div class="face-icon">
                            @if($room->target_user()->avatar )
                                <span><img src="{{ asset('storage/users') . "/" . $room->target_user()->id . "/" . $room->target_user()->avatar }}"></span>
                            @else
                                <span><img src="{{ asset('assets/user/img/common/person.png') }}"></span>
                            @endif
                        </div>
                        <div class="nameandmessage">
                            <div class="talk-people-name">{{ is_object($room->target_user()) ? $room->target_user()->name : '' }}</div>
                            <div class="talk-people-message">{{ is_object($room->message) ? $room->message->message : '' }}</div>
                        </div>
                        <div class="talk-people-situation">
                            <time>{{ (new DateTime($room->message->created_at))->format('Y.m.d H:i:s') }}</time>
                            @if($room->unread_messages_count())
                                <span class="count">{{ $room->unread_messages_count() }}</span>
                            @endif
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    {{--<div class="container">
        <h3>チャットリスト</h3>
        @foreach($rooms as $room)
            <a href="{{ route('chat.room', ['room_id' => $room->chat_room_id]) }}">
                <div class="chat-list mb-2 pl-4 pb-3">
                    <img style="width:150px">
                    <div style="width:300px">
                        <span>{{ is_object($room->target_user()) ? $room->target_user()->name : '' }}</span>
                        @if($room->unread_messages_count())
                            <span class="new-count">{{ $room->unread_messages_count() }}</span>
                        @endif
                        <p>{{ is_object($room->message) ? $room->message->message : '' }}</p>
                    </div>
                    <div style="width: 250px">
                        <span>{{ (new DateTime($room->message->created_at))->format('Y-m-d H:i:s') }}</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>    --}}
@endsection

@section('page_css')
    <style>
        a {
            text-decoration: none;
        }

        .chat-list {
            background-color: #dcdfe6;
        }

        .new-count {
            padding: 3px 8px;
            background-color: red;
            border-radius: 50%;
        }
    </style>
@endsection