<?php

    require_once("functions.php");

    session_start();
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $user = new user($username);
    $login = $user -> login($password);
    $detail = $login['detail'];
    $classname = $detail['classname'];
    if($detail['per'] == "teacher"){
        if(isset($_POST['test_name'])){
            $username = $_SESSION['username'];
            $test_name = $_POST['test_name'];
            $select_answer = $_POST['select_answer'];
            $answer = $_POST['answer'];
            $select_answer_score = $_POST['select_answer_score'];
            $answer_score = $_POST['answer_score'];
            $homework = new homework($test_name,$username);
            $result = $homework -> set_homework($select_answer,$select_answer_score,$answer,$answer_score,$classname);
            echo($result['code']);
        }
    }
    else{
        echo("You are not a teacher .");

    }

?>