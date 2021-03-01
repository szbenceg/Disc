<!doctype html>

<html>
<head>

    <title>Chat</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <link rel="stylesheet" href="css/chat.css">
</head>

<body>

    <div class="whole-chat-container">
        <div class="messages-list-container">
            <div class="messages-list-title"><div id="message-list-title-text">Üzenetek</div></div>
            <div class="message-list-boxes-container">
                <!--<div class="message-list-box">
                    <div class="message-list-box-content-container">
                        <div class="message-list-box-sender">Nagy László</div>
                        <div class="message-list-box-text">Kedves lászló arról érdeklődnék van e </div>
                    </div>
                </div>-->
            </div>
        </div>

        <div class="chat-container">
            <div class="chat-header">
                <div class="chat-title"></div>
            </div>
            <div class="messages-container">
            </div>
            
            <div class="send-message-container">
                <textarea placeholder="Üzenet..." class="text-message-box" id="message-text"></textarea>
                <button style="outline: none;" id="send-text-message">Küldés</button>
            </div>
        </div>
    </div>

    <div id="sound"></div>

    <script>

        var lastSelectedMessage = 0;

        function getUrlVars() {
            var vars = {};
            var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
                vars[key] = value;
            });
            return vars;
        }

        $.ajax({
            url: "ajaxrequest.php",
            type: "POST",
            data:{
                requestType: "getMessages",
                senderId: getUrlVars()["senderId"]
            },
            dataType: "json",
            success: function(data){
                if(data.messages != null){
                    
                    $(".chat-title").append(data.userName);
                    for(var i=0; i<data.messages.length; i++){
                        if(data.messages[i]["sender_id"] != getUrlVars()["senderId"]){
                            $(".messages-container").append(
                                "<div class='message-line'>" +
                                    "<div class='message-text right-message'>" +
                                        data.messages[i]["message"] +
                                    "</div>" +
                                "</div>"
                            );
                        }else{
                            $(".messages-container").append(
                                "<div class='message-line'>" +
                                    "<div class='message-text left-message'>" +
                                        data.messages[i]["message"] +
                                    "</div>" +
                                "</div>"
                            );
                        }
                        lastSelectedMessage = data.messages[i]["id"];
                    }
                    updateMessages(lastSelectedMessage);
                    $(".messages-container").animate({ scrollTop: $('.messages-container').prop("scrollHeight")}, 0);
                }
            }
        });

        function sendChatMessage(){

            if($("#message-text").val().length == ""){
            }else{
                $.ajax({
                    url: "ajaxrequest.php",
                    type: "POST",
                    data:{
                        requestType: "sendChatMessage",
                        receiverId: getUrlVars()["senderId"],
                        textMessage: $("#message-text").val()
                    },
                    dataType: "json",
                    success: function(data){
                        $(".text-message-box").val("");
                    }
                });
            }   
        }

        $(document).on('keypress',function(e) {
            if(e.which == 13) {
                sendChatMessage();
            }
        });

        $("#send-text-message").click(function(){
            sendChatMessage();
        });

        function updateMessages(lastSelectedMessage){
            window.setInterval(function(){
                $.ajax({
                    url: "ajaxrequest.php",
                    type: "POST",
                    data:{
                        requestType: "updateMessages",
                        senderId: getUrlVars()["senderId"],
                        lastSelectedId: lastSelectedMessage
                    },
                    dataType: "json",
                    success: function(data){

                        if(data.messages != null){
                            for(var i=0; i<data.messages.length; i++){
                                if(data.messages[i]["sender_id"] != getUrlVars()["senderId"]){
                                    $(".messages-container").append(
                                        "<div class='message-line'>" +
                                            "<div class='message-text right-message'>" +
                                                data.messages[i]["message"] +
                                            "</div>" +
                                        "</div>"
                                    );
                                }else{
                                    $(".messages-container").append(
                                        "<div class='message-line'>" +
                                            "<div class='message-text left-message'>" +
                                                data.messages[i]["message"] +
                                            "</div>" +
                                        "</div>"
                                    );
                                }
                                lastSelectedMessage = data.messages[i]["id"];
                            }
                            $(".messages-container").animate({ scrollTop: $('.messages-container').prop("scrollHeight")}, 1000);
                        }                        
                    }
                });
            }, 1000);
        }


        $.ajax({
            url: "ajaxrequest.php",
            type: "POST",
            data:{
                requestType: "getRequestMessages"
            },
            dataType: "json",
            success: function(data){

                /*console.log(data.message[data.message.length-1]["message"]);
                console.log(data.message.length);*/

                console.log(data.opp);

                if(data.message != null){
                    for(var i=0; i<data.message.length; i++){
                        $(".message-list-boxes-container").append(
                            "<a class='message-list-elements' href='index.php?location=chat&senderId="+data.message[i]["senderId"]+"'><div class='message-list-box'>" +
                                "<div id="+data.message[i]["senderId"]+" class='message-list-box-content-container'>" +
                                    "<span id='newMessage"+data.message[i]["senderId"]+"' class='new-message-num-pos'></span>"+
                                    "<div class='message-list-box-sender'>" + data.message[i]["userName"] + "</div>" +
                                    "<div class='message-list-box-text'>"+data.lastMessage[i]+"</div>" +
                                "</div>" +
                            "<div class='messages-list-border'></div>" +
                            "</a>"
                        );
                    }
                }

                $(".message-list-box-content-container").click(function(){
                    receiveMessage($(this).attr("id"));
                });

            }
        });

        function receiveMessage(senderId){
            if(senderId == null){
                var senderId = getUrlVars()["senderId"];
            }
            $.ajax({
                url: "ajaxrequest.php",
                type: "POST",
                data:{
                    requestType: "receivedMessage",
                    senderId: senderId
                },
                dataType: "json",
                success: (data)=>{
                    //console.log(data.success);
                }
            });
        }

        $(".chat-container").click(()=>{
            receiveMessage();
        });

        function updateNewMessages(){
            $.ajax({
                url: "ajaxrequest.php",
                type: "POST",
                data:{
                    requestType: "getNumOfNewMessages"
                },
                dataType: "json",
                success: (data)=>{
                    for(var i=0; i<data.senderId.length; i++){
                        if(data.messageNumber[i] == 0){
                            $("#newMessage" + data.senderId[i]).html("");
                            $("#" + data.senderId[i]).css("font-weight", "400");
                        }else{
                            $("#newMessage" + data.senderId[i]).html(data.messageNumber[i]);
                            $("#" + data.senderId[i]).css("font-weight", "600");
                        }
                    }
                }
            });            
        }

        updateNewMessages();

        function playSound(filename){
            var mp3Source = '<source src="audio/' + filename + '.mp3" type="audio/mpeg">';
            var oggSource = '<source src="audio/' + filename + '.ogg" type="audio/ogg">';
            var embedSource = '<embed hidden="true" autostart="true" loop="false" src="audio/' + filename +'.mp3">';
            document.getElementById("sound").innerHTML='<audio autoplay="autoplay">' + mp3Source + oggSource + embedSource + '</audio>';
        }


    </script>


</body>
</html>