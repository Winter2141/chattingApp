<script>
    var g_filename = "";
    $(document).ready(function () {
        $('#file_upload').click(function () {
            $.ajaxUploadSettings.name = 'vfile';
        }).ajaxUploadPrompt({
            url: '{{ route("chat.ajaxFileUpload") }}',
            data: {_token: '<?php echo csrf_token() ?>'},

            beforeSend: function (e) {
                fullPath = $("input[name=vfile]").val();
                if (fullPath) {
                    var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
                    var filename = fullPath.substring(startIndex);
                    if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                        filename = filename.substring(1);
                    }
                    g_filename = filename;
                }
            },
            onprogress: function (e) {
                if (e.lengthComputable) {
                    var percentComplete = e.loaded / e.total;
                    $("#fileprogressbar").progressbar({
                        value: percentComplete * 100,
                        change: function (e, ui) {
                            //var $this = $(this), val = $this.progressbar('option', 'value');
                            //$this.find('#percent').html(parseInt(val)+'%');
                        },
                        complete: function () {
                            $(this).progressbar("destroy");
                        }
                    });
                }
            },
            error: function () {
                //showDialog("添付ファイル", "添付ファイルアップロードに失敗しました。")
            },
            success: function (filename) {
                $("#ufilename").parent().show();
                $("#ufilename").html(g_filename);
                $("#tmp_file_name").val(filename);
                $("#r_file_name").val(g_filename);
                g_filename = "";
            },
            accept: "*.*"
        });
    });

    (function () {

        var clearResizeScroll, insertPartner, insertMe, lol, conf;
        var first_date='', last_date='';

        conf = {
            cursorcolor: "#696c75",
            cursorwidth: "4px",
            cursorborder: "none"
        };

        lol = {
            cursorcolor: "#cdd2d6",
            cursorwidth: "4px",
            cursorborder: "none"
        };

        clearResizeScroll = function () {
            $("#message_text").val("");
            $("#delete_download_file").hide();
            $("#ufilename").html("").attr("href", "#");
            // goBottomScroll();
        };



        insertMe = function (message, position='start') {
            var template = $("#me_template").clone();
            template.attr('id', 'me_template_' + message['id']);
            template.attr('message_id', message['id']);
            var stime = moment(message['created_at'], 'YYYY-MM-DD hh:mm:ss').format('YYYY.MM.DD hh:mm:ss');

            current_date =  moment(message['created_at'], 'YYYY-MM-DD hh:mm:ss').format('YYYY.MM.DD');


            $("#me_message_time", template).html(stime);
            $("#me_message", template).html(message['message']);

            /*var hasFile = (message['file_name'] != null);
            if (hasFile) {
                $(".file", template).show();

                if (message['message'] != null){
                    $('#space_1', template).attr('style', 'height:10px');
                }
                $(".file", template).show();
                $("#me_filepath", template).html(message['file_name']);
                @if($user_type == 2)
                    $("#me_filepath", template).attr("href", "/admin/chat/download/" + message['id']);
                @else
                    $("#me_filepath", template).attr("href", "/chat/download/" + message['id']);
                @endif
            }*/

            template.show();

            if(position == 'start') {
                $(".messages").prepend(template);
                if ($('#latest_id').val() == 0) {
                    //goBottomScroll();
                }
            } else {
                //$("#msg-sending", template).show();
                $(".messages").append(template);
                clearResizeScroll();
            }

        };

        insertPartner = function (message, position='start') {
            var template = $("#partner_template").clone();

            template.attr('message_id', message['id']);
            template.attr('id', 'partner_template_' + message['id']);

            var stime = moment(message['created_at'], 'YYYY-MM-DD hh:mm:ss').format('YYYY.MM.DD hh:mm:ss');
            $("#partner_message_time", template).html(stime);

            //$("#partner_picture", template).attr('src', 'storage/users/' + message['talker_id'] + '/' + message['file_path']);

            $("#partner_message", template).html(message['message']);

            /*var hasFile = (message['file_name'] != null);
            if (hasFile) {
                $(".file", template).show();

                if (message['message'] != null){
                    $('#space_1', template).attr('style', 'height:10px');
                }
                $("#partner_filepath", template).html(message['file_name']);

                @if($user_type == 2)
                $("#partner_filepath", template).attr("href", "/admin/chat/download/" + message['id']);
                @else
                $("#partner_filepath", template).attr("href", "/chat/download/" + message['id']);
                @endif
            }*/

            template.show();

            if(position == 'start') {
                $(".messages").prepend(template);
            } else {
                $(".messages").append(template);
                if (position !='start') {
                    //goBottomScroll();
                }
            }
        };

        getMessages = function(method='old') {
            //method new->get new messages, old->get old messagesd
            var chat_room_id = $('#chat_room_id').val();
            var latest_id = $('#latest_id').val();
            $.ajax({
                type: "post",
                url: " {{ route('chat.getMessages') }}",
                data: {
                    id: chat_room_id,
                    _token: "{{ csrf_token() }}",
                    latest_id: latest_id,
                    get_method: method
                },
                dataType: "json",
                success: function(data) {
                    if (method == 'old') {
                        var previous_messages = data['previous_messages'];

                        insertMessages(previous_messages, 'start');

                        if (previous_messages.length > 0) {
                            $('#latest_id').val(previous_messages[previous_messages.length-1]['id']);
                        }
                    } else {
                        var result = data['new_messages'];
                        if ( result['messages'] ) {
                            insertMessages(result['messages'], 'end')
                        }
                    }
                },
            });
        };

        insertMessages = function(messages, type) {
            for (i = 0; i < messages.length; i++) {
                var message = messages[i];
                if(message['talker_id'] == "{{ $user_id }}") {
                    insertMe(message, type)
                } else {
                    insertPartner(message, type)
                }
            }
        };

        deleteFile = function() {
            var tmp_file_name = $("#tmp_file_name").val();
            var r_file_name = $("#r_file_name").val();
            $.ajax({
                type: "post",
                url: " {{ route('chat.deleteFile') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    tmp_file: tmp_file_name,
                    real_name: r_file_name
                },
                dataType: "json",
                success: function(data) {
                    $("#ufilename").parent().hide();
                    $("#ufilename").html('');
                    $("#tmp_file_name").val('');
                    $("#r_file_name").val('');
                },
                error: function(){

                },
                complete: function() {

                }
            });
        };

        sendMessage = function(msg, id) {
            var chat_room_id = $('#chat_room_id').val();
            var tmp_file = $('#tmp_file_name').val();
            var real_file = $('#r_file_name').val();
            $.ajax({
                type: "post",
                url: " {{ route('chat.sendMessage') }}",
                data: {
                    chat_room_id: chat_room_id,
                    _token: "{{ csrf_token() }}",
                    message: msg,
                    tmp_file: tmp_file,
                    real_file: real_file
                },
                dataType: "json",
                success: function(data) {
                    if (data['result_code'] == 'success') {
                        $('#me_template_just_sent').remove();
                        var result = data['new_messages'];
                        if ( result['messages'] ) {
                            insertMessages(result['messages'], 'end');
                        }
                    }
                },
            });
        };

        insertSend = function () {
            message = [];
            message['id'] = 'just_sent';
            message['message'] = $.trim($("#message_text").val());
            message['file_name'] = $("#r_file_name").val();
            message['file_path'] = $("#tmp_file_name").val();
            message['created_at'] = new Date();


            /*if ( message['file_name'] !='' ||  message['message'] !='' ) {*/
            if ( message['message'] !='' ) {
                insertMe(message, 'end');
                sendMessage(message['message'],  message['id']);
            }
            $("#r_file_name").val('');
            $("#tmp_file_name").val('');
        };

        getRandomInt = function (min, max) {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min)) + min;
        };

        getNewMessages = function () {
            setInterval(function () {
                getMessages('new');
            }, 5000);
        };

        onload = function(){
            var els = document.getElementsByTagName('textarea');
            for (var i = 0; i < els.length; i++){
                var obj = els[i];
                resize(obj);
                obj.onkeyup = function(){ resize(this); }
            }
        };

        $(document).ready(function () {

            document.location.href='#last';

            moment.locale('ja');

            getMessages();

            getNewMessages();

            //$(document).niceScroll(conf);

            //$(document).niceScroll(lol);

            $("#message_text").keydown(function(e){
                if (e.keyCode === 13 && e.ctrlKey) {
                    insertSend();
                    return false;
                }
            });

            $(".send").click(function () {
                insertSend();
            });

            $("#delete_download_file").click(function () {
                if (confirm("ファイルを削除します。よろしいですか？")) {
                    deleteFile();
                }
            });

            $(document).scroll(function(){
                if ($(document).scrollTop() == 0){
                    getMessages();
                }
            });
        });

    }).call(this);

    function goBottomScroll () {
        $('html, body').animate({scrollTop:  $(document).height()}, 800);
        //$(document).getNiceScroll(0).resize();
        //return $(document).getNiceScroll(0).doScrollTop(999999, 999);
    }

    function resize(Tarea){
        var areaH = Tarea.style.height;
        areaH = parseInt(areaH) - 35;
        if(areaH < 35){ areaH = 35; }
        Tarea.style.height = areaH + "px";
        Tarea.style.height = parseInt(Tarea.scrollHeight + 5) + "px";
    }

    function add_class_in_scrolling(target) {
        var winScroll = $(window).scrollTop();
        var winHeight = $(window).height();
        var scrollPos = winScroll + winHeight;

        if(target.offset().top < scrollPos) {
            $('.chat-comment').addClass('is-show');
        }
        else if(target.offset().top > scrollPos) {
            $('.chat-comment').removeClass('is-show');
        }
    }
</script>