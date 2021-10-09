@extends('layouts.main')

@section('header')
    <div id="header">
        <p><a href="{{ route('contact') }}"><</a></p>
        <h1 class="maintitle">ADD CONTACT</h1>
    </div>
@endsection

@section('content')
<div class="search-box">
    <input type="text" class="type-box" name="search_by_name" id="search_by_name" placeholder="Input Name For Add." value="{{ old('search') }}">
    <input type="submit" class="scope">
</div>

<div class="name_search_result">
</div>
@endsection

@section('page_js')
    <script>
        $(document).ready(function() {
            $('#search_by_name').keyup(function(e){
                e.preventDefault();
                var search_str = $(this).val();
                $.ajax({
                    type : 'post',
                    url : "{{ route('contact.addSearch') }}",
                    data : {
                        'search_by_name' : search_str,
                        _token:'<?php echo csrf_token() ?>',
                    },
                    success:function(response){
                            $('.name_search_result').empty().html(response);
                    }
                    });
            });
        })
    </script>
@endsection