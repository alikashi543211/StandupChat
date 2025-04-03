<div id="sidepanel">
    <div id="profile">
        <div class="wrap">
            <img id="profile-img" src="{{ url(Auth::user()->image) }}" class="online" alt="" />
            <p>{{ Auth::user()->name }}</p>
            <i class="fa fa-chevron-down expand-button" aria-hidden="true"></i>
            <div id="status-options">
                <ul>
                    <li id="status-online" class="active"><span class="status-circle"></span> <p>Online</p></li>
                    <li id="status-away"><span class="status-circle"></span> <p>Away</p></li>
                    <li id="status-busy"><span class="status-circle"></span> <p>Busy</p></li>
                    <li id="status-offline"><span class="status-circle"></span> <p>Offline</p></li>
                </ul>
            </div>
            <div id="expanded">
                <label for="twitter"><i class="fa fa-list fa-fw" aria-hidden="true"></i></label>
                <a href="{{ url('profile') }}" class="profile_button">
                    <input name="twitter" type="text" readonly value="Profile" />
                </a>
                <label for="twitter"><i class="fa fa-user fa-fw" aria-hidden="true"></i></label>
                <input name="twitter" type="text" readonly value="{{ Auth::user()->name }}" />
                <label for="twitter"><i class="fa fa-envelope fa-fw" aria-hidden="true"></i></label>
                <input name="twitter" type="text" readonly value="{{ Auth::user()->phone_number }}" />
            </div>
        </div>
    </div>
    <div id="search">
        <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
        <input type="text" placeholder="Search contacts..." />
    </div>
    <div id="contacts">
        <ul>
            @foreach($users as $user)
                <li data-user-id='{{ $user->id }}' class="contact @if($activeChatUser->id == $user->id) active @endif">
                    <div class="wrap">
                        <span class="contact-status online"></span>
                        <img src="{{ $user->image }}" alt="" />
                        <div class="meta">
                            <p class="name">{{ $user->name }}</p>
                            <p class="preview">{{ $user->phone_number }}</p>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <div id="bottom-bar">
        <a href="{{ url('user/contacts/add') }}">
            <button id="addcontact"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>Add contact</span></button>
        </a>
        <a href="{{ url('user/profile') }}">
            <button id="settings"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Settings</span></button>
        </a>
    </div>
</div>
