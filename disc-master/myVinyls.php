    <div style="margin-top: 60px;"></div>

    <button class="upload-vinyl">Lemez feltöltés</button>

    <div class="slide-container music-style-view">
        <div class="slide-title-container">
            <div class="slide-title"><a href="index.php">Saját lemezeim</a></div>
        </div>
        <div style="white-space: normal; height: 100%; overflow:hidden; display: table; text-align: center;" class="vinyls-container" id="genre-vinyls-container">
        </div>
    </div>


    <script>

        $.ajax({
            url: "ajaxrequest.php",
            method: "POST",
            data: {
                requestType: "getOwnDiscs"
            },
            dataType: "json",
            success:function(data){
                
                for(var i=0; i<data["discId"].length; i++){
                    $("#genre-vinyls-container").append(
                        "<div id='DMpop" + i + "' class='image-container'>" +
                            "<a href=index.php?location=specs&discId="+ data["discId"][i] +"><img class='vinyl-image' src='vinyls/" + data["discId"][i] + ".jpg'></a>" +
                            "<div class='image-description'>"+ data["album"][i] +"</div>" +
                        "</div>"
                    );
                }
            }
        });

    </script>

</body>
</html>


<script>


    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            vars[key] = value;
        });
        return vars;
    }

    $(".upload-vinyl").click(function(){
        $("body").append(
            "<div class='upload-container'>" +
                "<div class='upload-box'>"+
                    "<div class='close-upload'>" +
                        "<img onclick='removeMessageBox()' class='close-image' src='images/close.jpg'/>" +
                    "</div>" +
                    "<div class='upload-box-title'>" +
                        "Lemez Feltöltés" +
                    "</div>" +
                    "<div class='input-info-container'><div class='disc-specs'>" +
                        "<div class='disc-artist'>" +
                            "<div class='info'>A lemez előadója:</div>" +
                            "<input type='text' class='artist'>" +
                        "</div>" +
                        "<div class='disc-album-name'>" +
                            "<div class='info'>A lemez címe: </div>" +
                            "<input type='text' class='album-name'>" +
                        "</div>" +
                        "<div class='disc-genre'>" +
                            "<div class='info'>A lemez műfaja: </div>" +
                            "<select class='genre'>" +
                                "<option value='pop'>Pop</option>" +
                                "<option value='rock'>Rock</option>" +
                                "<option value='hipHop'>Hip-hop</option>" +
                                "<option value='electronical'>Elektornikus</option>" +
                                "<option value='classical'>Klasszikus</option>" +
                                "<option value='country'>Country</option>" +
                            "</select>" +
                        "</div>" +
                        "<div class='disc-released'>" +
                            "<div class='info'>A lemez kiadási éve: </div>" +
                            "<input type='text' class='released'>" +
                        "</div>" +
                        "<div class='disc-country'>" +
                            "<div class='info'>A lemez kiadási helye: </div>" +
                            "<input type='text' class='country'>" +
                        "</div>" +
                        "<div class='disc-condition'>" +
                            "<div class='info'>A lemez állapota: </div>" +
                            "<input type='text' class='condition'>" +
                        "</div>" +
                        "<div class='disc-description'>" +
                            "<div class='info'>Egyéb megjegyzés: </div>" +
                            "<input type='text' class='description'>" +
                        "</div>" +
                        "<div class='disc-image'>" +
                            "<label tabindex='0' class='input-file-title'>Kép a lemezről: </label>" +
                            "<input class='input-file' type='file' id='image' accept='image/*'>" +
                        "</div>" +    
                        "<div class='upload-buttons-container'>" +
                            "<button type='button' onclick='removeUploadBox()' class='upload-button'>Mégsem</button>" +
                            "<button type='button' onClick='uploadVinyl()' class='upload-button'>Feltöltés</button>" +
                        "</div>" +
                    "</div></div>" +
                "</div>" +
            "</div>"
        );
    });

    function removeMessageBox(){
        $("div").remove(".upload-container");
    }
    

    function uploadVinyl(){
        var fd = new FormData();
        var files = $('#image')[0].files[0];
        fd.append('image', files);
        fd.append('requestType', "uploadVinyl");
        fd.append('artist', $(".artist").val());
        fd.append('albumName', $(".album-name").val());
        fd.append('genre', $(".genre").val());
        fd.append('released', $(".released").val());
        fd.append('country', $(".country").val());
        fd.append('condition', $(".condition").val());
        fd.append('description', $(".description").val());

        console.log(fd);

        $.ajax({
            url: "./ajaxrequest.php",
            type: "POST",
            data: fd,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(data){
                if(data.success){
                    console.log(5);
                    removeMessageBox();
                }else{
                    console.log(6);
                    alert(data.errorMessage);
                }
            },
            error: function(err){
                console.log(err.responseText);
            }
        });
    }

</script>

</body>
</html>
