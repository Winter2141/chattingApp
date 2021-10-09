@extends('layouts.main')

@section('header')
<div id="header">
    <h1 class="maintitle">Address</h1>
            <ul class="head-btn">
        <li><p><a class="float-right" href="{{ route('contact.add') }}">＋</a></p></li>
    </ul>
</div>
@endsection

@section('content')
<div class="search-box">
    <input type="text" class="type-box" name="search" id="search" placeholder="People & Groups" value="{{ old('search') }}">
    <input type="submit" class="scope">
</div>

<ul class="talk-box search_result">
    @if ($contacts->count() > 0)
        @include('contact.contactTable')
    @else
        <li class="text-center text-white">
            <p>No Contact.</p>
        </li>
    @endif
</ul>
@endsection

@section('page_js')
<script>
    $(document).ready(function (){
        $('#search').keyup(function(){
            var search_str = $(this).val();
            $.ajax({
                type : 'post',
                url : "{{ route('contact.ajaxSearch') }}",
                data : {
                    'search_name' : search_str,
                    _token:'<?php echo csrf_token() ?>',
                },
                success:function(response){
                        $('.search_result').empty().html(response);
                }
                });
        })
    });
</script>
@endsection