@extends('layouts.main')

@section('header')
<div id="header">
    <p><a href="{{ route('contact') }}"><</a></p>
        <h1 class="maintitle">User Information</h1>
                <ul class="head-btn">
    <li><p><a href="{{ route('contact.add') }}">＋</a></p></li>
    </ul>
</div>
@endsection

@section('content')
    <div id="wrapper">
        <div class="contact-face text-white">
            <div class="trimming">
                @if ($user->avatar != null)
                    <img src="{{ asset('storage/').'/users/'.$user->id.'/'.$user->avatar }}" alt="">
                @else
                    <img src="{{ asset('user/img/common/person.png') }}">
                @endif
            </div>
            <p class="name">{{ $user->name }}</p>
            @if ($status != 4)
            <ul style="width: 100%">
                <li style="display: inline-flex">
                    <input type="submit" value="Accept Request" class="type-ok2 btn_accept">
                    <form id="frm_accept" action="{{ route('contact.accept', ['id'=>$user->id]) }}" method="post" style="display: none;">
                        @method('POST')
                        @csrf
                    </form>
                </li>
                <li style="display: inline-flex">
                    <input type="submit" value="Reject Request" class="btn_reject type-ok2">
                    <form id="frm_reject" action="{{ route('contact.reject', ['id'=>$user->id]) }}" method="post" style="display: none;">
                        @method('POST')
                        @csrf
                    </form>
                </li>
            </ul>
            @else
                @php
                    $url = route('chat.room', ['target_id' => $user->id]);
                @endphp
                <input class="type-ok2" type="submit" value="Send Message" onclick="location.href='{{ $url }}'"/>
            @endif
        </div>
        <div  style="margin-top: 10px;">
            <table class="table table-striped table-dark text-white text-center" style="background-color: transparent">
                <tr>
                    <th class="text-center text-white">ADDRESS</th>
                    <td>{{ $user->address }}</td>
                </tr>
                <tr>
                    <th class="text-center text-white">PROFILE</th>
                    <td> <?php echo nl2br($user->profile) ?> </td>
                </tr>
            </table>
        </div>
    </div>

<div id="dialog-confirm" title="test" style="display:none">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
        <span id="confirm_text"></span>
    </p>
</div>
@endsection

@section('page_css')
@endsection

@section('page_js')
    <script>
        $(document).ready(function () {
            $(".btn_accept").click(function(e){
                e.preventDefault();
                var result = confirm('Accept Request?');
                if(result) {
                    var frm_id = "#frm_accept";
                    $(frm_id).submit();
                }
            });

            $(".btn_reject").click(function(e){
                e.preventDefault();
                var result = confirm('Reject Request？');
                if(result) {
                    var frm_id = "#frm_reject";
                    $(frm_id).submit();
                }
            });

        } );

    </script>
@endsection