<?php

    require("../config.php");
    class homework{
        function __construct($test_name="",$username=""){
            require("../config.php");
            $this -> init_score();
            $this -> db = $db;
            $this -> test_name = $test_name;
            $this -> username = $username;
            $this -> corrects = array();
            $this -> incorrects = array();
            $this -> answerss = "";
            $this -> selectss = "";
            
        }
        function init_score(){
            $this -> score = 0;
        }
        function create_uuid($prefix=""){
            $chars = md5(uniqid(mt_rand(), true));
            $uuid = substr ( $chars, 0, 8 ) . '-'
                . substr ( $chars, 8, 4 ) . '-'
                . substr ( $chars, 12, 4 ) . '-'
                . substr ( $chars, 16, 4 ) . '-'
                . substr ( $chars, 20, 12 );
            return $prefix.$uuid ;
        }
        function get_all_homework($classname){
            $db = $this -> db;
            $username = $this -> username;
            $command = "select * from homework where classname='$classname'";
            $result = mysqli_query($db,$command);
            $result = mysqli_fetch_all($result);
            $x = 0;
            foreach ($result as $homework_item){
                $completes = $homework_item[8];
                $completes = explode(",",$completes);
                $isin = in_array($username,$completes);
                if($isin == false){
                    $state = "false";
                }
                else{
                    $state = "true";
                }
                $result[$x][8] = $state;
                $x += 1;
            }
            return array(
                "code" => "4000",
                "msg" => "Homework has been returned .",
                "detail" => $result
            );
        }
        function get_homework_by_id($test_id){
            $username = $this -> username;
            $db = $this -> db;
            $command = "select * from homework where test_id='$test_id'";
            $result = mysqli_query($db,$command);
            $result = mysqli_fetch_assoc($result);
            $this -> correct_select = $result['select_answer'];
            $this -> correct_answer = $result['answer'];
            if(empty($result)){
                return array(
                    "code" => 5001,
                    "error" => "Homework not found ."
                );
            }
            else{
                return array(
                    "code" => 5000,
                    "msg" => "Homework has been returned .",
                    "detail" => $result
                );
            }
        }
        function correct($test_id,$qnum,$n){
            $corrects = $this -> corrects;
            array_push($corrects,$qnum);
            $this -> corrects = $corrects;
            $username = $this -> username;
            $db = $this -> db;
            $score = $this -> score;
            $homework = $this -> get_homework_by_id($test_id);
            $homework = $homework['detail'];
            $test_name = $homework['test_name'];
            $classname = $homework['classname'];
            $select_answer_score = $homework['select_answer_score'];
            $select_answer_score = explode("|",$select_answer_score);
            $select_scores = array();
            foreach ($select_answer_score as $item){
                $item = explode(",",$item);
                array_push($select_scores,$item);
            }
            //$select_answer_score = (float)$select_answer_score;
            $answer_score = $homework['answer_score'];
            $answer_score = explode("|",$answer_score);
            $answer_scores = array();
            foreach ($answer_score as $item){
                $item = explode(",",$item);
                array_push($answer_scores,$item);
            }
            //$answer_score = (float)$answer_score;
            $table_name = $test_name . "_" . $classname;
            $command = "select * from $table_name where number='$qnum'";
            $result = mysqli_query($db,$command);
            $result = mysqli_fetch_assoc($result);
            $corrects = $result['correct'];
            $qtype = $result['q_type'];
            if($qtype == "select"){
                foreach($select_scores as $item){
                    if(((int)($item[0]) <= (int)$qnum) && ((int)($item[1]) >= (int)$qnum)){
                        $thisscore = (float)($item[2]);
                        $score += $thisscore;
                    }
                }
                $selectss = $this -> selectss;
                if($selectss == ""){
                    $selectss .= $n;
                }
                else{
                    $selectss .= ",$n";
                }
                $this -> selectss = $selectss;
            }
            else{
                foreach($answer_scores as $item){
                    if(((int)($item[0]) <= (int)$qnum) && ((int)($item[1]) >= (int)$qnum)){
                        $thisscore = (float)($item[2]);
                        $score += $thisscore;
                    }
                }
                $answerss = $this -> answerss;
                if($answerss == ""){
                    $answerss .= $n;
                }
                else{
                    $answerss .= ",$n";
                }
                $this -> answerss = $answerss;
            }
            if($corrects == ""){
                $corrects .= "$username";
            }
            else{
                $corrects .= ",$username";
            }
            $command = "update $table_name set correct='$corrects' where number='$qnum'";
            @mysqli_query($db,$command);
            $this -> score = $score;
            return array(
                "code" => 6000,
                "msg" => "Judge ok"
            );
        }
        function incorrect($test_id,$qnum,$n){
            $incorrects = $this -> incorrects;
            array_push($incorrects,$qnum);
            $this -> incorrects = $incorrects;
            $username = $this -> username;
            $db = $this -> db;
            $homework = $this -> get_homework_by_id($test_id);
            $homework = $homework['detail'];
            $test_name = $homework['test_name'];
            $classname = $homework['classname'];
            $table_name = $test_name . "_" . $classname;
            $command = "select * from $table_name where number='$qnum'";
            $result = mysqli_query($db,$command);
            $result = mysqli_fetch_assoc($result);
            $incorrects = $result['incorrect'];
            $qtype = $result['q_type'];
            if($qtype == "select"){
                $selectss = $this -> selectss;
                if($selectss == ""){
                    $selectss .= $n;
                }
                else{
                    $selectss .= ",$n";
                }
                $this -> selectss = $selectss;
            }
            else{
                $answerss = $this -> answerss;
                if($answerss == ""){
                    $answerss .= $n;
                }
                else{
                    $answerss .= ",$n";
                }
                $this -> answerss = $answerss;
            }
            if($incorrects == ""){
                $incorrects .= "$username";
            }
            else{
                $incorrects .= ",$username";
            }
            $command = "update $table_name set incorrect='$incorrects' where number='$qnum'";
            @mysqli_query($db,$command);
            return array(
                "code" => 6000,
                "msg" => "Judge ok"
            );
        }
        function complete_homework($test_id){
            $username = $this -> username;
            $db = $this -> db;
            $corrects = $this -> corrects;
            $incorrects = $this -> incorrects;
            $correct_select = $this -> correct_select;
            $correct_answer = $this -> correct_answer;
            $command = "select * from homework where test_id='$test_id'";
            $result = mysqli_query($db,$command);
            $result = mysqli_fetch_assoc($result);
            $completes = $result['complete'];
            $classname = $result['classname'];
            $test_name = $result['test_name'];
            if($completes == ""){
                $completes .= $username;
            }
            else{
                $completes .= ",$username";
            }
            $command = "update homework set complete='$completes' where test_id='$test_id'";
            @mysqli_query($db,$command);
            $score = $this -> score;
            $selectss = $this -> selectss;
            $answerss = $this -> answerss;
            $command = "update $test_name" . "_$classname" . "_score set score='$score',select_answer='$selectss',answer='$answerss' where name='$username'";
            @mysqli_query($db,$command);
            return array(
                "corrects" => $corrects,
                "incorrects" => $incorrects,
                "correct_select" => $correct_select,
                "correct_answer" => $correct_answer,
                "scores" => $score

            );
        }
        function check_homework(){
            $test_name = $this -> test_name;
            $username = $this -> username;
            $db = $this -> db;
            $command = "select * from homework where test_name='$test_name' and username='$username'";
            $result = mysqli_query($db,$command);
            $result = mysqli_fetch_assoc($result);
            if(empty($result)){
                return array(
                    "code" => 2001,
                    "msg" => "Homework not found ."
                );
            }
            else{
                return array(
                    "code" => 2002,
                    "msg" => "Homework exist .",
                    "detail" => $result
                );

            }
        }

        function get_q($test_id){
            $db = $this -> db;
            $username = $this -> username;
            $result = $this -> get_homework_by_id($test_id);
            $result = $result['detail'];
            $test_name = $result['test_name'];
            $classname = $result['classname'];
            $table_name = "$test_name" . "_$classname";
            $command = "select * from $table_name";
            $result = mysqli_query($db,$command);
            $result = mysqli_fetch_all($result);
            return array(
                "code" => 8000,
                "msg" => "Questions have been got .",
                "detail" => $result
            );
        }

        function get_scores($test_id){
            $db = $this -> db;
            $result = $this -> get_homework_by_id($test_id);
            $result = $result['detail'];
            $test_name = $result['test_name'];
            $classname = $result['classname'];
            $table_name = $test_name . "_$classname" . "_score";
            $command = "select * from $table_name";
            
            $result = mysqli_query($db,$command);
            $result = mysqli_fetch_all($result);
            return array(
                "code" => 7000,
                "msg" => "Scores get completely",
                "detail" => $result
            );
        }
        function set_homework($select_answer,$select_answer_score,$answer,$answer_score,$classname){
            $test_name = $this -> test_name;
            $username = $this -> username;
            $homework_c = $this -> check_homework();
            $uuid = $this -> create_uuid();
            $db = $this -> db;
            if($homework_c['code'] == 2001){
                $command = "insert into homework values('$test_name','$uuid','$select_answer','$select_answer_score','$answer','$answer_score','$username','$classname','')";
                mysqli_query($db,$command);
                $command = "CREATE TABLE $test_name"."_$classname( ".
                    "number mediumtext, ".
                    "correct mediumtext, ".
                    "incorrect mediumtext, ".
                    "q_type mediumtext);";
                @mysqli_query($db,$command);
                $command = "CREATE TABLE $test_name"."_$classname" . "_score( ".
                    "name mediumtext, ".
                    "score mediumtext, ".
                    "select_answer mediumtext, ".
                    "answer mediumtext".
                    ");";
                @mysqli_query($db,$command);
                $command = "select * from users where classname='$classname' and per='student'";
                $result = mysqli_query($db,$command);
                $result = mysqli_fetch_all($result);
                foreach($result as $item){
                    $name = $item[0];
                    $command = "insert into $test_name" . "_$classname" . "_score values('$name','','','')";
                    @mysqli_query($db,$command);
                }
                $select_answer = explode(",",$select_answer);
                $x = 1;
                foreach ($select_answer as $select_answer_item){
                    $command = "insert into $test_name" . "_$classname values('$x','','','select')";
                    mysqli_query($db,$command);
                    $x += 1;
                }
                $answer = explode(",",$answer);
                foreach ($answer as $answer_item){
                    $command = "insert into $test_name" . "_$classname values('$x','','','answer')";
                    mysqli_query($db,$command);
                    $x += 1;
                }
                


                return array(
                    "code" => 3000,
                    "msg" => "Set successfully ."
                );
            }
            else{
                if($homework_c['code'] == 2002){
                    return array(
                        "code" => 3001,
                        "msg" => "Homework exist .",
                        "detail" => $result
                    );
                }
                else{
                    return array(
                        "code" => 3001,
                        "msg" => "Unkown error ."
                    );
                }
            }
        }
    }

    class user{
        function __construct($username){
            require("../config.php");
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
                        "msg" => "Login success .",
                        "detail" => $result
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