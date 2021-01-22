<?php

    require_once("functions.php");
    session_start();
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $user = new user($username);
    $login = $user -> login($password);
    $logincode = $login['code'];
    if($logincode == 200){

    }
    else{
        echo("Please login first.");
        header("location:/");
        exit();
    }
    $postdata = $_POST;
    $test_id = $postdata['test_id'];
    $selects = array();
    $answers = array();
    $x = 1;
    foreach($postdata as $postitem){
        if(isset($postdata["select_$x"])){
            array_push($selects,$postdata["select_$x"]);
        }
        else{
            if(isset($postdata["answer_$x"])){
                array_push($answers,$postdata["answer_$x"]);
            }
        }
        $x += 1;
    }
    $homework = new homework($test_name="",$username=$username);
    $homework_detail = $homework -> get_homework_by_id($test_id);
    $homework_detail = $homework_detail['detail'];
    $select_answer = $homework_detail['select_answer'];
    $select_answer_score = $homework_detail['select_answer_score'];
    $select_answer_score = (float)$select_answer_score;
    $answer = $homework_detail['answer'];
    $answer_score = $homework_detail['answer_score'];
    $answer_score = (float)$answer_score;
    $select_answer = explode(",",$select_answer);
    $answer = explode(",",$answer);
    $total = 0;
    $x = 0;
    foreach($select_answer as $select_answer_item){
        if($select_answer_item == $selects[$x]){
            $homework -> correct($test_id,$x+1,$selects[$x]);
            //$total += $select_answer_score;
        }
        else{
            $homework -> incorrect($test_id,$x+1,$selects[$x]);
        }
        $x += 1;
    }
    $j = 0;
    foreach($answer as $answer_item){
        if($answer_item == $answers[$j]){
            $homework -> correct($test_id,$x+1,$answers[$j]);
            //$total += $answer_score;
        }
        else{
            $homework -> incorrect($test_id,$x+1,$answers[$j]);
        }
        $x += 1;
        $j += 1;
    }
    $result = $homework -> complete_homework($test_id);
    print_r($result);

?>