@foreach($messages as $message)
    @if($message->user_id == Auth::id())

        @if($message->attachments)
            <li class="sent image-message-item"><img src="{{ Auth::user()->image }}" alt="" />
                <p class="image-message-box">
                    <a href="{{ url($message->attachments) }}" target="_blank">
                        <img class="image-message" src="{{ asset($message->attachments) }}" alt="Chat Image">
                    </a>
                </p>
            </li>
        @else
            <li class="sent"><img src="{{ $message->user->image }}" alt="" />
                <p>{{ $message->message }}</p>
            </li>
        @endif

    @else

        @if($message->attachments)
            <li class="replies image-message-item"><img src="{{ Auth::user()->image }}" alt="" />
                <p class="image-message-box">
                    <a href="{{ url($message->attachments) }}" target="_blank">
                        <img class="image-message" src="{{ asset($message->attachments) }}" alt="Chat Image">
                    </a>
                </p>
            </li>
        @else
            <li class="replies"><img src="{{ $message->user->image }}" alt="" />
                <p>{{ $message->message }}</p>
            </li>
        @endif

    @endif
@endforeach

