<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ env("APP_NAME", "Chat App") }}</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link rel="stylesheet" href="{{ asset('chat-assets/css/custom.css') }}">
    </head>
    <body>
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">

            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    @if(env('DISPLAY_LOGO'))
                        <img src="{{ asset('chat-assets/images/standupchat-logo-white-background.png') }}" width="100" alt="">
                    @else
                        {{ env("APP_NAME", "Chat App") }}
                    @endif

                </a>
                <!-- Links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('user/profile') }}">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('user/contacts/add') }}">Add Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('chat') }}">Chat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout_button" href="javascript:void(0);">Logout</a>
                        <form action="{{ url('logout') }}" id="logoutForm" method="POST">@csrf</form>
                    </li>
                </ul>
            </div>

        </nav>
        <div class="container mt-5">
            @yield('content')
        </div>

        <script>
            $(document).on("click", ".logout_button", function(){
                $("#logoutForm").submit();
            })
        </script>
        @yield('script')
    </body>
</html>
