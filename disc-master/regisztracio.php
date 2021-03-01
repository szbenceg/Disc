

        <div id="registration-whole-container">
            <div id="registration-container">
                <div id="registration-title"><h1>Regisztráció</h1></div>
                <p><input class="login-input" type="text" placeholder = "Felhasználónév" id ="text"></p>
                <p><input class="login-input" type="email" placeholder = "Email cím" id = "email"></p>
                <p><input class="login-input" type = "text" placeholder ="Jelszó" id = "password"></p>
                <p><input class="login-input" type = "text" placeholder ="Jelszó megismétlése" id = "passwordagain"></p>
                <p><button class="login-button"t ype = "submit" id = "button">Regisztrálás</button></p>
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

            if ($('#password').val() == $('#passwordagain').val() && $('#password').val() != ""){

                $.ajax({
                    url: "ajaxrequest.php",
                    method: "POST",
                    data: {
                        requestType: "registration",
                        userName: $('#text').val(),
                        emailAddress: $('#email').val(),
                        password: $('#password').val()
                    },
                    dataType: "json",
                    success:function(data){
                        if (data.success){
                            window.location.href = "index.php";
                        }
                    },
                    error:function(error){
                        console.log(error.responseText);
                    }
                });
            } else {
                alert("A két jelszó nem egyezik.");
            }
        } else {
            alert("Helytelen email");
        }
    });
    
</script>