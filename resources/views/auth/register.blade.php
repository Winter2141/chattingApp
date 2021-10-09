@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-center">REGISTER</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="contact-face">
                            <div class="face-wrap">
                                <div class="face m-auto">
                                    <label class="file_mask">
                                        <span>
                                        <img class="profile_image" src="{{ asset('user/img/common/person.png') }}">
                                        </span>
                                    </label>
                                    <label for="profile_image" id="file_upload" class="plusicon"><img src="{{asset('user/img/icon/plus.png')}}" style="width: 20px" alt=""></label>
                                    <input type="hidden" name="avatar" id="file_path" value="" />
                                </div>
                            </div>
                        </div>
        
                        <div class="form-group row">
        
                                <input id="name" type="text" class="type-box @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Name" required autocomplete="name" autofocus>
        
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
        
                        <div class="form-group row">
        
                                <input id="email" type="email" class="type-box @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email">
        
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
        
                        <div class="form-group row">
        
                            <input id="password" type="password" class="type-box" name="password" required autocomplete="new-password" placeholder="Password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
        
                        <div class="form-group row">
        
                                <input id="password-confirm" type="password" class="type-box" name="password_confirmation" required autocomplete="new-password" placeholder="Password-Comfirm">
                            
                        </div>
        
                        <div class="form-group row">
                                <input id="address" type="text" class="type-box @error('address') is-invalid @enderror" value="{{ old('address') }}" name="address" required placeholder="Address">
        
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        
                        <div class="form-group row">
                            <textarea name="profile" id="profile" class="form-control @error('profile') is-invalid @enderror" cols="20" rows="5" required placeholder="Profile">{{ old('profile') }}</textarea>
                            @error('profile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <input type="submit" class="type-ok" value="Register">
        
                    </form>
                </div>
            </div>
            <input type="hidden"  value="{{ asset('storage/') }}" id="file_storage"/>

            
        </div>
    </div>
</div>
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
    <script>
        $(document).ready(function() {
            $('#file_upload').click(function(){
                $.ajaxUploadSettings.name = 'vfile';
            }).ajaxUploadPrompt({
                url : '{{ route("user.upload.avatar") }}',
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
