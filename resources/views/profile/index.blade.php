@extends('layouts.main')

@section('header')
    Profile
@endsection

@section('content')
    <div>
        <div class="contact-face">
            <div class="face-wrap">
                <div class="face m-auto">
                    <label class="file_mask">
                        <span>
                            @if ($user->avatar != null)
                            <img class="profile_image"  src="{{ asset('storage/')."/users/".$user->id."/".$user->avatar }}" alt="">
                            @else
                            <img class="profile_image" src="{{ asset('user/img/common/person.png') }}">
                            @endif
                        </span>
                    </label>
                    <label for="profile_image" id="file_upload" class="plusicon"><img src="{{asset('user/img/icon/plus.png')}}" style="width: 20px" alt=""></label>
                    <input type="hidden" name="avatar" id="file_path" value="" />
                </div>
            </div>
        </div>
        <div class="text-white text-center">
            <h2 style="font-size: 20px;">{{$user->name}}</h2>
        </div>
        
        <table class="table table-striped table-dark text-center">
            <tr>
                <td>Email</td>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <td>Address</td>
                <td>
                    {{ $user->address }}
                    <div>
                        @php
                            echo $map['html']
                        @endphp
                    </div>
                    <div>
                        {{ Form::open(["route"=>"profile", "method"=>"get"]) }}
                            <input type="text" name="address" class="input-text" value="{{ old('address') }}">
                            <input type="submit" value="MAP" class="type-ok2">
                        {{ Form::close() }}
                    </div>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: middle;">Profile</td>
                <td style="text-align: left"> <?php echo nl2br($user->profile) ?> </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="button" value="LOGOUT" class="type-ok2" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </td>
            </tr>
        </table>
    </div>
    <input type="hidden"  value="{{ asset('storage/') }}" id="file_storage"/>
@endsection

@section('page_css')
<link href="{{ asset('vendor/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/datetimepicker/jquery.datetimepicker.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/chat/css/normalize.css') }}" rel="stylesheet">
@endsection

@section('page_js')
<script src="{{ asset('vendor/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('vendor/ajaxupload/jquery.ajaxupload.js') }}"></script>
<script type="text/javascript">
    var centreGot = false;
</script>
@php
    echo $map['js'];
@endphp
    <script>
        $(document).ready(function() {
            $('#file_upload').click(function(){
                $.ajaxUploadSettings.name = 'vfile';
            }).ajaxUploadPrompt({
                url : '{{ route("update.avatar") }}',
                data: {_token:'<?php echo csrf_token() ?>'},
                beforeSend : function () {
                    $("input[type=submit]").prop('disabled', true);
                    fullPath = $("input[name=vfile]").val();
                    if (fullPath) {
                        var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
                        var filename = fullPath.substring(startIndex);
                        if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                            filename = filename.substring(1);
                        }
                        g_filename = filename;
                        $('#file_name').val(filename);
                    }
                },
                error : function () {
                    showDialog("添付ファイル", "添付ファイルアップロードに失敗しました。");
                    $("input[type=submit]").prop('disabled', false);
                },
                success : function (file_name) {
                    var file_path = $("#file_storage").val();
                    file_path += "/temp/";
                    file_path += file_name;
                    $("#file_path").val(file_name);
                    $("#file_name").val(g_filename);
                    $("#imgSrc").attr('src', file_path);
                    $("#imgSrc").css('display', 'inline');
                    $(".profile_image").attr('src', file_path);
                    $("#ufilename").text(g_filename);
                    $("#uploaded_file").show();
                    $("input[type=submit]").prop('disabled', false);
                },
                accept: "image/*"
            });
        });
    </script>
@endsection