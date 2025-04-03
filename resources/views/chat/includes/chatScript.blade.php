<script>

    var currentChannelName = '';
    var activeChatUserId = null;

    const loadChatMessages = () => {

        $.ajax({

            method: 'POST',
            url: '{{ url("chat/load-messages") }}',
            data: {
                _token: '{{ csrf_token() }}',
            },
            success: function(response){
                console.log(response)
                currentChannelName = response.data.currentChannelName
                activeChatUserId = response.data.activeChatUserId
                displayAllMessages(response.data.data);
                displayActiveChatUserSection(response.data.activeChatUser);

            }

        })

    }

    const displayActiveChatUserSection = (data) => {

        $("#active-chat-user-section").html(data);

    }

    const checkChannelExists = (user_id) => {

        $.ajax({

            method: 'POST',
            url: '{{ url("chat/check-channel-exists") }}',
            data: {
                _token: '{{ csrf_token() }}',
                user_id: user_id
            },
            success: function(response){
                console.log(response)

                if(response.data.channelExists == false)
                {
                    createChannel(user_id)
                }else{
                    currentChannelName = response.data.data.name
                }

                loadChannelMessages(user_id);

            }

        })

    }

    const createChannel = (user_id) => {

        $.ajax({

            method: 'POST',
            url: '{{ url("chat/create-channel") }}',
            data: {
                _token: '{{ csrf_token() }}',
                user_id: user_id
            },
            success: function(response){
                console.log(response)
                currentChannelName = response.data.data.name
            }

        })

    }

    const broadcastMessage = (user_id, message) => {

        $.ajax({

            method: 'POST',
            url: '{{ url("chat/broadcast-message") }}',
            data: {
                _token: '{{ csrf_token() }}',
                user_id: user_id,
                message: message,
                channel: currentChannelName

            },
            success: function(response){
                console.log(response)

            }

        })

    }

    const newMessage = () => {

        message = $(".message-input input").val();

        if($.trim(message) == '') {
            return false;
        }

        const messageElement = `
            <li class="sent">
                <img src="chat-assets/images/default.png" alt="" />
                <p>${message}</p>
            </li>`;

        $(messageElement).appendTo($('.messages ul'));

        $('.message-input input').val(null);

        messagesBoxScrollFullDown();

        broadcastMessage(activeChatUserId, message);

    }

    $(document).on('click', '.submit', function(){

        newMessage();

    });

    $(window).on('keydown', function(e) {
        if (e.which == 13) {
            $('body').find('.submit').click();
            return false;
        }
    });

    const loadChannelMessages = (user_id) => {

        $.ajax({

            method: 'POST',
            url: '{{ url("chat/load-channel-messages") }}',
            data: {
                _token: '{{ csrf_token() }}',
                user_id: user_id
            },
            success: function(response){
                console.log(response)
                displayAllMessages(response.data.data);
                displayActiveChatUserSection(response.data.activeChatUser);
            }

        })

    }

    const messagesBoxScrollFullDown = () => {

        $(".messages").animate({ scrollTop: '10000px' }, "fast");

    }

    const displayAllMessages = (data) => {

        $('.messages ul').html(data);

        messagesBoxScrollFullDown();

    }



    const displayAllMessagesByFrontend = (data) => {

        for(item of data)
        {

            console.log(item);

            if(item.user_id == '{{ Auth::user()->id }}')
            {

                $(`<li class="sent"><img src="chat-assets/images/default.png" alt="" /><p>${item.message}</p></li>`).appendTo($('.messages ul'));

            }else{

                $(`<li class="replies"><img src="chat-assets/images/default.png" alt="" /><p>${item.message}</p></li>`).appendTo($('.messages ul'));

            }


        }

    }

    loadChatMessages();

    $(document).on('click', '.contact', function(){

        $("#contacts .contact").removeClass('active');

        $(this).addClass('active');

        activeChatUserId = $(this).attr('data-user-id');

        checkChannelExists(activeChatUserId);

    });



</script>
