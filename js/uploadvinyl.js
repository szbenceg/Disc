$(".upload-vinyl").click(function(){
    $("body").append(
        "<div class='message-container'>" +
            "<div class='message-box'>"+
                "<div class='close-email'>" +
                    "<img onclick='removeMessageBox()' class='close-image' src='images/close.jpg'/>" +
                "</div>" +
                "<div class='message-box-title'>" +
                    "Érdeklődés" +
                "</div>" +
                "<div class='text-message-box-container'>" +
                    "<div class='text-message-box' contenteditable='true'>" +
                    "</div>" +
                    "<div class='message-fill-advice'>" +
                        "(Az üzenet írása növelheti a csere esélyét)" +
                    "</div>" +
                    "<div class='message-description'>" +
                        "Érdeklődését továbbítjuk a lemez tulajdonosának, a feltöltött lemezeivel, és ezzel az üzenettel együtt!" +
                    "</div>" +
                    "<div class='send-message-buttons-container'>" +
                        "<button type='button' onclick='removeMessageBox()' class='send-message-button'>Mégsem</button>" +
                        "<button type='button' onClick='sendMessage()'class='send-message-button'>Küldés</button>" +
                    "</div>" +
                "</div>" +
            "</div>" +
        "</div>"
    );
});


function removeMessageBox(){
    $("div").remove(".message-container");
}

function sendMessage(senderId, ownerId){
    $.ajax({
        url: "./ajaxrequest.php",
        type: "POST",
        data:{
            requestType: "sendMessage",
            senderId: senderId,
            ownerId: ownerId,
            message: $(".text-message-box").html()
        },
        dataType: "json",
        success: function(data){
            if(data.success){
                removeMessageBox();
            }else{
                alert(data.errorMessage);
            }
        }
    });
}
