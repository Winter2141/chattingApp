
<ul class="talk-box">
    @if (isset($contacts))
        @if ($contacts->count() > 0)
            @foreach ($contacts as $contact)
            <li> 
                <a>
                <div class="face-icon">
                    <span>
                        @if ($contact->avatar != null)
                        <img src="{{ asset('storage/').'/users/'.$contact->id.'/'.$contact->avatar }}">
                        @else
                        <img src="{{ asset('user/img/common/person.png') }}">
                        @endif
                    </span> 
                </div>
                <div class="nameandmessage">
                    <div class="text-white">{{ $contact->name }}</div>
                    <div class="talk-people-message">
                        {{ $contact->address }}
                    </div>
                </div>
                <div class="talk-people-situation">
                    <input class="btn_request type-ok2" type="submit"  cidx = "{{ $contact->id }}" value="Send Request">
                    <form action="{{ route('contact.add_request', ['id'=>$contact->id]) }}" method="GET" id="frm_request_{{ $contact->id }}"  style="display: none">
                        @csrf
                    </form>
                </div>
            </a>
            </li>
            @endforeach
        
        @else
        <li>
            <p class="text-center text-white">No Search Result.</p>
        </li>
        @endif
    @endif
</ul>

<script>
    $(document).ready(function (){
        $(".btn_request").click(function(e){
                e.preventDefault();
                var id = $(this).attr('cidx');
                var result = confirm('Add Friend Requst OK？');
                if(result) {
                    var frm_id = "#frm_request_" + id;
                    $(frm_id).submit();
                }
            });
    });
</script>