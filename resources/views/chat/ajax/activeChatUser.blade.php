@if($activeChatUser)
    <img src="{{ $activeChatUser->image }}" alt="" />
    <p>{{ $activeChatUser->name }} <span class="typing">Typing...</span></p>
    <div class="social-media">
        <i class="fa fa-facebook" aria-hidden="true"></i>
        <i class="fa fa-twitter" aria-hidden="true"></i>
        <i class="fa fa-instagram" aria-hidden="true"></i>
    </div>
@else
    <img src="{{ asset('chat-assets/images/default.png') }}" alt="" />
    <p>No Contacts Found</p>
    <div class="social-media">

    </div>
@endif
