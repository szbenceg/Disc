<?php

    session_start();

    include "head.php";

    if(array_key_exists("userId", $_COOKIE)){
        $_SESSION["userId"] = $_COOKIE["userId"];
    }
    if(array_key_exists("userId", $_SESSION)){

        include "loggedinbalckheader.php";

        if(!array_key_exists("location", $_GET) OR $_GET["location"] != "chat"){
            include "musicheader.php";
        }

    }else if(array_key_exists("location", $_GET) AND ($_GET["location"] == "logIn" OR $_GET["location"] ==  "signIn")){
        include "notloggedinblackheader.php";
    }else{
        include "notloggedinblackheader.php";
        include "musicheader.php";
    }

    if(array_key_exists("location", $_GET)){
        if($_GET["location"] == "specs"){

            include "specs.php";

        }else if($_GET["location"] == "specGenre"){

            include "specgenre.php";

        }else if($_GET["location"] == "logIn"){

            include "bejelentkezes.php";

        }else if($_GET["location"] == "signIn"){

            include "regisztracio.php";

        }else if($_GET["location"] == "chat"){

            include "chat.php";

        }else if($_GET["location"] == "myVinyls"){

            include "myVinyls.php";

        }else{

            include "mainpage.php";

        }
    }else{
        include "mainpage.php";
    }
    

?>