<?php
// Session Management
if(strpos($_SERVER['REQUEST_URI'], '/auth-login.php') !== false){
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: /");
        exit;
    }
} else if(!isset($_SESSION["loggedin"])){
    header("location: /auth-login.php");
    exit;
}

?>