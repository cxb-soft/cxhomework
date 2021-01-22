<?php

    const TESTNAME = "Test_20200115_202015"

    require_once("config.php");
    $db = $db;
    $command = "select * from " . TESTNAME;
    $result = mysqli_query($db,$command);
    $result = mysqli_fetch_all($result);
    $x = 1;
    foreach($result as $item){
        $corrects = explode(",",$item[1]);
        $incorrects = explode(",",$item[2]);
        
        $corrects = array_unique($corrects);
        $incorrects = array_unique($incorrects);
        $correct = "";
        $incorrect = "";
        foreach($corrects as $itemc){
            $itemc .= ",";
            $correct .= $itemc; 
        }
        $correct = rtrim($correct, ","); 
        foreach($incorrects as $itemc){
            $itemc .= ",";
            $incorrect .= $itemc; 
        }
        $incorrect = rtrim($incorrect, ","); 
        $command = "update " . TESTNAME . " set correct='$correct',incorrect='$incorrect' where number='$x'";
        mysqli_query($db,$command);
        $x += 1;

    }

?>