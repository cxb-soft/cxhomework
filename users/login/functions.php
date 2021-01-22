<?php

    class user{
        function __construct($username){
            require_once("../config.php");
            $this -> db = $db;
            $this -> username = $username;
            $this -> password = "";
        }
        function login($password){
            $username = $this -> username;
            $db = $this -> db;
            $command = "select * from users where username='$username'";
            $result = mysqli_query($db,$command);
            $result = mysqli_fetch_assoc($result);
            if(!empty($result)){
                $cor_password = $result['password'];
                if($password == $cor_password){
                    $this -> password = $password;
                    return array(
                        "code" => 200,
                        "msg" => "Login success ."
                    );
                }
                else{
                    $this -> password = "";
                    return array(
                        "code" => 1002,
                        "error" => "Password incorrect . Please check ."
                    );
                }
            }
            else{
                return array(
                    "code" => 1001,
                    "error" => "User not found . Login failed ."
                );
            }
        }
    }

?>