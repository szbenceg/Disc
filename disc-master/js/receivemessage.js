window.setInterval(function(){
    //$(".my-messages-number").html(" (5)");
    $.ajax({
        url: "./ajaxrequest.php",
        type: "POST",
        data:{
            requestType: "getReceivedMessagesNumber"
        },
        dataType: "json",
        success: function(data){
            $(".my-messages-number").html(" ("+ data.messagesNumber +")")
        }
    });
}, 3000);

