@extends('layouts.main')

@section('header')
    <div id="header">
        <p><a href="javascript:history.back()"><</a></p>
        <h1 class="maintitle">Chat</h1>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="hide">
            <h2 class="timetitle" id="time_template"></h2>

            <!--②左コメント始-->
            <div class="balloon partner_message target-contents mb-1" id="partner_template">
                <div class="otheruser-date">
                    <time id="partner_message_time"></time>
                </div>
                <div class="chatting">
                    <div class="faceicon"> 
                        @if ($target_user->avatar)
                            <img src="{{ asset('storage/users')."/".$target_user->id."/".$target_user->avatar }}" alt=""> 
                        @else
                            <img src="{{ asset('assets/user/img/common/person.png') }}">
                        @endif
                    </div>
                    <div class="says">
                        <p id="partner_message"></p>
                        {{--<div class="file">
                            <i class="fa fa-download"><a href="#" id="partner_filepath" class="file-download"></a></i>
                        </div>--}}
                    </div>

                </div>
            </div>
            <!--②/左コメント終-->

            <!--③右コメント始-->
            <div id="me_template" class="my-contents mb-1">
                <div class="user-date">
                        <time id="me_message_time"></time>
                </div>
                <div class="mycomment">
                    <p id="me_message" oncontextmenu="showContext()"></p>
                   {{-- <div class="file">
                        <i class="fa fa-download"><a href="#" id="me_filepath" class="file-download"></a></i>
                    </div>--}}
                </div>
            </div>
            <!--/③右コメント終-->
        </div>

        <input type="hidden" id="chat_room_id" name="chat_room_id" value="{{ $room_id }}">
        <input type="hidden" id="latest_id" name="latest_id" value="0">

        <div class="line-bc messages">
        </div>

        <div id="last"></div>
        <div class="comment-wrappper">
            <div class="chat-comment">
               {{-- <div class="uploaded-file">
                <span >
                    <i class="fa fa-trash" id="delete_download_file" style="display:none;" ><span id="ufilename" style="margin-left: 10px;"></span></i>
                </span>
                    <input type="hidden" id="r_file_name">
                    <input type="hidden" id="tmp_file_name">
                    <div id="fileprogressbar"></div>
                </div>--}}
                <ul>
                   {{-- <li>
                        <input type="button" id="file_upload" value="ファイル選択" >
                    </li>--}}
                    <li>
                        <textarea name="message_text" id="message_text"></textarea>
                        {{--<p class="help-key">Enterキー：改行、Ctrl＋Enterキー：送信</p>--}}
                    </li>
                    <li>
                        <input type="submit" class="send" value="送信">
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <ul class="context-menu" style="display: none">
        <li>delete</li>
        <li>edit</li>
    </ul>
@endsection

@section('page_css')
    <link href="{{ asset('vendor/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
    <style>
        div.hide {
            display: none;
        }

        .mycomment p, .says p{
            white-space: pre-wrap;
        }
    </style>
@endsection

@section('page_js')
    <script src="{{ asset('vendor/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('vendor/ajaxupload/jquery.ajaxupload.js') }}"></script>
    <script src="{{ asset('vendor/chat/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('vendor/moment/moment.js') }}"></script>
    <script src="{{ asset('vendor/moment/moment-with-locales.js') }}"></script>
    @include('share.chat.chat_js')

    <script>
        function showContext(){
            e.preventDefault();
            alert("Contact menu Clicked");
            console.log("Contact menu Clicked");
            $(".context-menu").css('display', 'block');
        }
    </script>
@endsection