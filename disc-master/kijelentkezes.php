<?php ob_start();

    session_start();

    unset($_SESSION);
    unset($_COOKIE);
    setcookie("userId", null, time() - 60*60, "/");
    session_destroy();
    header("Location: index.php");
    
ob_end_flush();?>