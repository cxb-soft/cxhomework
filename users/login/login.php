<?php

    require_once("functions.php");

    if(isset($_POST['username'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user = new user($username);
        $loginresult = $user -> login($password);
        if($loginresult['code'] == 200){
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            echo("success");
        }
        else{
            echo($loginresult['code']);
        }
    }
    else{
        echo(json_encode(array(
            "code" => "1000",
            "error" => "Incorrect par"
        )));
    }

?>