<!DOCTYPE html>

<html class=''>
    <head>

        @include('chatTheme.includes.head')

    </head>
    <body>

        <div id="frame">

            @include("chatTheme.includes.sidepanel")

            <div class="content">

                @include("chatTheme.includes.contactProfile")

                @include("chatTheme.includes.messages")

                @include("chatTheme.includes.messageInput")

            </div>
        </div>

        @include("chatTheme.includes.footerScript")

    </body>
</html>
