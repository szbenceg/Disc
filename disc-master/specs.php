<div style="margin-top: 60px;"></div>
<div class="main-container">
    <div class="specs-container">
        <div class="specs-title-container">
            <div class="specs-title"></div>
            <div class="back"><a href="index.php">Vissza a főoldalra</a></div>
        </div>
        <div class="content-container">
            <div class="cover-image-container">
                <img class="cover-image" src="vinyls/<?=$_GET["discId"]?>.jpg">
            </div>
            <div class="data-container">
                <div class="artist data-item first-data-item">Előadó: </div>
                <div class="album data-item">Album: </div>
                <div class="year data-item">Kiadás éve: </div>
                <div class="condition data-item">Lemez állapota: </div>
                <div class="owner data-item">Tulajdonos neve: </div>
                <button class="interested-button send-message">Érdekel</button>
            </div>
        </div>
    </div>
</div>


<script>


    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            vars[key] = value;
        });
        return vars;
    }

    $.ajax({
        url: "ajaxrequest.php",
        method: "POST",
        data: {
            requestType: "getSpecDisc",
            discId: getUrlVars()["discId"]
        },
        dataType: "json",
        success:function(data){
            $(".artist").append(data.artist);
            $(".album").append(data.album);
            $(".year").append(data.released);
            $(".condition").append(data.disc_condition);
            $(".owner").append(data.user_name);
            $(".specs-title").append(data.artist + ": " + data.album);
            $(".interested-button").click(function(){
                if(data.senderId == null){
                    alert("Üzenet írásához regisztráció szükséges!");
                }else{
                    messageBox(data.senderId, data.id);
                }
            });
        },
        error:function(error){
            console.log(error.responseText);
        }
    });
</script>

</body>
</html>
