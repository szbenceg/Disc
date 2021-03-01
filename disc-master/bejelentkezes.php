
    <div class="login-body">
        <div class = "login-frame">
            <div class = "login-top "><p><h1>Bejelentkezés</h1></p></div> 
            <div ><p><input class = "login-input" type="email" placeholder="Email cím" id="email"></p></div> 
            <div ><p><input class = "login-input-2" type="text" placeholder="Jelszó" id="password"></p></div> 
            <div ><p><button type="submit" id="button" class = "login-button">Belépés</button></p></div> 
        </div> 
    </div>

</body>

</html>



<script>

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    $('#button').click(function() {
        if (isEmail($('#email').val())){
            $.ajax({
                url: "ajaxrequest.php",
                method: "POST",
                data: {
                    requestType: "logIn",
                    emailAddress: $('#email').val(),
                    password: $('#password').val()
                },
                dataType: "json",
                success:function(data){

                    if(data.success){
                        window.location.href = "index.php";
                    }else{
                        console.log(data.message);
                    }

                },
                error:function(error){
                    console.log(error.responseText);
                }
            });
        } else {
            alert("Helytelen email");
        }
    });
    
</script>