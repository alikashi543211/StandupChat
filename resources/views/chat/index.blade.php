<!DOCTYPE html>

<html class=''>
    <head>

        @include('chat.includes.head')

    </head>
    <body>


        <div id="frame">

            @include("chat.includes.sidepanel")

            <div class="content">

                @include("chat.includes.contactProfile")

                @include("chat.includes.messages")

                @include("chat.includes.messageInput")

            </div>
        </div>

        @include("chat.includes.footerScript")

    </body>
</html>
