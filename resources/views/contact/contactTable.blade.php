@foreach ($contacts as $contact)
<li> 
    <a href="{{ route('contact.show', ['id'=>$contact->sender_id]) }}">
        <div class="face-icon">
            <span>
            @if ($contact->send_user->avatar != null)
                <img src="{{ asset('storage/').'/users/'.$contact->sender_id.'/'.$contact->send_user->avatar }}" alt="">
            @else
                <img src="{{ asset('user/img/common/person.png') }}">
            @endif
            </span> 
        </div>
        <div class="nameandmessage">
            <div class="text-white">{{ $contact->send_user->name  }}</div>
            <div class="talk-people-message">
                {{ $contact->send_user->address }}
            </div>
        </div>
        <div class="talk-people-situation">
            @if ($contact->status != 4)
                <span class="wait">Request</span>
            @endif
        </div>
    </a>
</li>
@endforeach