import './bootstrap';
window.currentChannelName = '';
window.previousChannelName = '';
window.activeChatUserId = 0;
window.socketConnectionId = '';
window.sendingImageViewBoxClass = ".sending-image-view-box";
window.sendingImageItemClass = ".sending-image-item";
window.uploadedImagesArray = [];
window.userProfileImage = 'chat-assets/images/default.png';
window.userProfileDefaultImage = 'chat-assets/images/default.png';
window.isSubscribed = 0;

document.addEventListener('DOMContentLoaded', function () {


    var activeChatUserId = null;
    var csrf_token = $("meta[name=csrf-token]").attr("content")

    const loadChatMessages = () => {

        $.ajax({

            method: 'POST',
            url: 'chat/load-messages',
            data: {
                _token: csrf_token,
            },
            success: function(response){
                console.log(response)

                updateGlobalChatFlags(response.data.currentChannelName, response.data.activeChatUserId, response.data.userProfileImage);
                displayAllMessages(response.data.data);
                displayActiveChatUserSection(response.data.activeChatUser);
                subscribePrivateEvent()
            }

        })

    }

    const updateGlobalChatFlags = (currentChannelName, activeChatUserId, userProfileImage) =>
    {

        window.previousChannelName = window.currentChannelName;
        window.currentChannelName = currentChannelName;
        window.activeChatUserId = activeChatUserId;
        window.userProfileImage = userProfileImage;
        if(window.previousChannelName == '')
        {
            window.previousChannelName = currentChannelName;
        }

    }

    const loadChannelMessages = (user_id) => {

        $.ajax({

            method: 'POST',
            url: 'chat/load-channel-messages',
            data: {
                _token: csrf_token,
                user_id: user_id
            },
            success: function(response){
                console.log(response)
                updateGlobalChatFlags(window.currentChannelName, window.activeChatUserId, response.data.userProfileImage);
                displayAllMessages(response.data.data);
                displayActiveChatUserSection(response.data.activeChatUser);
            }

        })

    }

    const checkChannelExists = (user_id) => {

        $.ajax({

            method: 'POST',
            url: 'chat/check-channel-exists',
            data: {
                _token: csrf_token,
                user_id: user_id
            },
            success: function(response){
                console.log(response)

                if(response.data.channelExists == false)
                {
                    createChannel(user_id)
                }else{
                    updateGlobalChatFlags(response.data.data.name, user_id);
                }

                loadChannelMessages(user_id);
                subscribePrivateEvent();
            }

        })

    }

    const createChannel = (user_id) => {

        $.ajax({

            method: 'POST',
            url: 'chat/create-channel',
            data: {
                _token: csrf_token,
                user_id: user_id
            },
            success: function(response){
                console.log(response)

                updateGlobalChatFlags(response.data.data.name, user_id)
            }

        })

    }

    const broadcastMessage = (user_id, message) => {
        $.ajax({
            method: 'POST',
            url: 'chat/broadcast-message',
            data: {
                _token: csrf_token,
                user_id: user_id,
                message: message,
                channel: window.currentChannelName

            },
            headers: {
                'X-Socket-ID': window.Echo.socketId()
            },
            success: function(response){
                console.log(response)

            }

        })

    }

    const broadcastImages = (user_id, message) => {

        var formData = new FormData();
        formData.append('_token', csrf_token);
        formData.append('user_id', user_id);
        formData.append('channel', window.currentChannelName);
        for(var i = 0; i < window.uploadedImagesArray.length; i++)
        {
            formData.append('images[]', window.uploadedImagesArray[i]);
        }

        $.ajax({
            method: 'POST',
            url: 'chat/broadcast-images',
            data: formData,
            headers: {
                'X-Socket-ID': window.Echo.socketId()
            },
            contentType: false, // Prevent jQuery from setting content type
            processData: false, // Prevent jQuery from processing the data
            beforeSend: function(){
                const waitHtml = `<div class="chat-alert-info">
                                    Please wait...
                                </div>`;
                $(window.sendingImageViewBoxClass).html(waitHtml)
            },
            success: function(response){
                console.log(response)

                $(window.sendingImageViewBoxClass).html('');
                window.uploadedImagesArray = [];
                loadChatMessages();

            }

        })

    }

    const displayActiveChatUserSection = (data) => {

        $("#active-chat-user-section").html(data);

    }

    const newMessage = () => {

        var message = $(".message-input input").val();

        if($(window.sendingImageViewBoxClass).find(sendingImageItemClass).length > 0)
        {

            broadcastImages(activeChatUserId);

        }
        if($.trim(message) != '') {

            console.log("New Text Message is sending..");

            appendSentOrReceivedMessage('sent', message, window.userProfileImage);

            $('.message-input input').val(null);

            broadcastMessage(activeChatUserId, message);
        }

        return false;



    }

    const appendSentOrReceivedMessage = (flagClass, message, profileImageUrl = window.userProfileDefaultImage) => {

        const messageElement = `
            <li class="${flagClass}">
                <img src="${profileImageUrl}" alt="" />
                <p>${message}</p>
            </li>`;

        $(messageElement).appendTo($('.messages ul'));

        messagesBoxScrollFullDown();

    }

    const appendReceivedImage = (imageUrl, profileImageUrl) =>
    {

        var imageMessageHtml =
            `<li class="replies image-message-item"><img src="${profileImageUrl}" alt="" />
                <p class="image-message-box">
                    <a href="${imageUrl}" target="_blank">
                        <img class="image-message" src="${imageUrl}" alt="Chat Image">
                    </a>
                </p>
            </li>`

        $(imageMessageHtml).appendTo($('.messages ul'));

        messagesBoxScrollFullDown();

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

    const messagesBoxScrollFullDown = () => {

        $(".messages").animate({ scrollTop: '10000px' }, "fast");

    }

    const displayAllMessages = (data) => {

        $('.messages ul').html(data);

        messagesBoxScrollFullDown();

    }

    loadChatMessages();

    $(document).on('click', '.contact', function(){

        $("#contacts .contact").removeClass('active');

        $(this).addClass('active');

        activeChatUserId = $(this).attr('data-user-id');

        checkChannelExists(activeChatUserId);

    });

    $(document).on('click', ".sending-image-view-box .fa-close", function(){

        $(this).closest(".sending-image-item").remove();

        if($(".sending-image-view-box .sending-image-item").length == 0)
        {
            $(".sending-image-view-box").addClass('d-none');
        }

    })

    $(document).on("change", "#images-upload", function(event){

        console.log(event.target.files, event.target.files.length);
        window.uploadedImagesArray = [];
        var uploadedFileLength = event.target.files.length;

        $(window.sendingImageViewBoxClass).html('');

        for(var i = 0; i < uploadedFileLength; i++)
        {
            window.uploadedImagesArray[i] = event.target.files[i];

            const uploadedImagePath = URL.createObjectURL(event.target.files[i])

            const imageView = `
                <div class="col-md-3 sending-image-item">
                    <img width="20" src="${uploadedImagePath}">
                    <i class="fa fa-close" aria-hidden="true"></i>
                </div>
            `;

            $(imageView).appendTo(window.sendingImageViewBoxClass);

        }

    });

    $(document).on("click", ".message-camera-input", function(){

        $("#images-upload").click();

    })

    const subscribePrivateEvent = () => {

        console.log("Previous Channel Name = ", window.previousChannelName, "Current Channel Name = ", window.currentChannelName);

        if(window.currentChannelName == '')
        {
            return 0;
        }

        if(window.previousChannelName != window.currentChannelName && window.previousChannelName != '')
        {
            console.log("Previous Channel Leaving = ", 'channel-' + window.previousChannelName)
            window.Echo.leave('channel-' + window.previousChannelName);
            window.isSubscribed = 0
        }
        console.warn('Subsribing.....', 'channel-' + window.currentChannelName)
        if(window.isSubscribed == 1)
        {
            return null;
        }
        window.isSubscribed = 1;
        window.Echo.private(`channel-${window.currentChannelName}`)

            // Listen for the event called "button.clicked"
            .listen('.message.sent', (e) => {

                // Display the "message" in an alert box
                console.log(e);
                if(e.type == 'text')
                {
                    appendSentOrReceivedMessage("replies", e.message, e.profile_image);
                }else if(e.type == 'attachment')
                {

                    appendReceivedImage(e.message, e.profile_image);
                }

            });

    }

});





