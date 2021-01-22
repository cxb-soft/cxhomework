<?php

    require_once("functions.php");

    session_start();
    $test_id = $_GET['test_id'];
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $user = new user($username);
    $login = $user -> login($password);
    
    $logincode = $login['code'];
    if($logincode != 200){
        echo("Please login first.");
        header("location:/");
        exit();
    }
    else{
        $detail = $login['detail'];
        $classname = $detail['classname'];
        $per = $detail['per'];
        if($per == "teacher"){
            $isteacher = true;
        }
        else{
            $isteacher = false;
        }
        if($per == "student"){
            $isstudent = true;
        }
        else{
            $isstudent = false;
        }
        $_SESSION['isteacher'] = $isteacher;
        $_SESSION['per'] = $per;
        $_SESSION['isstudent'] = $isstudent;
    }

?>


<?php

    $homework = new homework($test_name="",$username=$username);
    $homework_list = $homework -> get_all_homework($classname);
    $homework_list = $homework_list['detail'];


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/mdui@1.0.1/dist/css/mdui.min.css"
        integrity="sha384-cLRrMq39HOZdvE0j6yBojO4+1PrHfB7a9l5qLcmRm/fiWXYY+CndJPmyu5FV/9Tw"
        crossorigin="anonymous"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo(WEBSITE) ?></title>
</head>
<body class="mdui-theme-layout-dark">
    <script
        src="https://cdn.jsdelivr.net/npm/mdui@1.0.1/dist/js/mdui.min.js"
        integrity="sha384-gCMZcshYKOGRX9r6wbDrvF+TcCCswSHFucUzUPwka+Gr+uHgjlYvkABr95TCOz3A"
        crossorigin="anonymous"
    ></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <div class="mdui-appbar">
        <div class="mdui-toolbar mdui-color-theme">
            <a href="javascript:toggle();" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">menu</i></a>
            <a href="javascript:;" class="mdui-typo-title">作业中心 - <?php echo($username) ?></a>
            <div class="mdui-toolbar-spacer"></div>
            <!--<a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">search</i></a>
            <a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">refresh</i></a>
            <a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">more_vert</i></a>-->
            <button class="mdui-btn mdui-btn-raised mdui-ripple" onclick="unlogin()">退出登录</button>
        </div>
    </div>
    <?php
    
        $scores = $homework -> get_scores($test_id);
        $scores = $scores['detail'];
        //print_r($scores);
    
    ?>
    <div style="padding-left:10%;padding-right:10%;padding-top:5%">
        <h3>成绩单</h3>
        <div class="mdui-divider"></div>
        <div class="mdui-table-fluid">
  <table class="mdui-table">
    <thead>
      <tr>
        <th>姓名</th>
        <th>分数</th>
        <th>选择题答案</th>
        <th>非选择题答案</th>
      </tr>
    </thead>
    <tbody>
    <?php
    
    foreach($scores as $item){
        $name = $item[0];
        $score = $item[1];
        $selectss = $item[2];
        $answerss = $item[3];
        if($score != ""){
            echo("
        
            <tr>
            <td>$name</td>
            <td>$score</td>
            <td>$selectss</td>
            <td>$answerss</td>
            </tr>
            
            ");
        }
        
    }
    
    
    ?>
    </tbody>
  </table>
  </div>
    </div>

    <?php
    
        $qs = $homework -> get_q($test_id);
        $qs = $qs['detail'];
        //print_r($qs);
    
    ?>

    <div style="padding-left:10%;padding-right:10%;padding-top:5%">
        <h3>每道题</h3>
        <div class="mdui-divider"></div>
        <div class="mdui-table-fluid">
            <table class="mdui-table">
                <thead>
                <tr>
                    <th>题号</th>
                    <th>答对人数</th>
                    <th>答错人数</th>
                    <th>正确率</th>
                </tr>
                </thead>
                <tbody>
        <?php

            foreach($qs as $item){
                $num = $item[0];
                $correct = $item[1];
                $correct = explode(",",$correct);
                $correct_l = count($correct);
                if($correct == [""]){
                    $correct_l -= 1;
                }

                $incorrect = $item[2];
                $incorrect = explode(",",$incorrect);
                $incorrect_l = count($incorrect);
                if($incorrect == [""]){
                    $incorrect_l -= 1;
                }
                $q_type = $item[3];
                @$corate = $correct_l / ($incorrect_l + $correct_l);
                $html = "
                
                <tr>
                <td>$num</td>
                <td>$correct_l</td>
                <td>$incorrect_l</td>
                <td>$corate</td>
                </tr>

                
                
                ";
                echo($html);
            }
        
        ?>
        </tbody>
  </table>
  </div>
    </div>




    <div style="padding-left:10%;padding-right:10%;padding-top:5%">
        <h3>未完成</h3>
        <div class="mdui-divider"></div>
        <div class="mdui-table-fluid">
  <table class="mdui-table">
    <thead>
      <tr>
        <th>姓名</th>
      </tr>
    </thead>
    <tbody>
    <?php
    
    foreach($scores as $item){
        $name = $item[0];
        $score = $item[1];
        $selectss = $item[2];
        $answerss = $item[3];
        if($score == ""){
            echo("
        
            <tr>
            <td>$name</td>
            </tr>
            
            ");
        }
        
    }
    
    
    ?>
    </tbody>
  </table>
  </div>
    </div>

    <script>
        function toggle(){
            var inst = new mdui.Drawer('#drawer');
            inst.toggle();
        }
        function check_homework(test_id){
            window.location = "/users/user/states.php"
        }
        function unlogin(){
            $.ajax({
             type: "POST",
             url: "/users/login/unlogin.php",
             data: {
                 
             },
             dataType: "text",
             success: function(data){
                mdui.snackbar({
                    message: '已注销,即将跳转...',
                    position: 'left-top'
                });
                setTimeout(() => {
                    window.location="/users/user/index.php"
                }, 2000);
             }
            })
        }
    </script>


    <div class="mdui-drawer mdui-drawer-close" id="drawer">
    <ul class="mdui-list mdui-typo">
        <li class="mdui-list-item mdui-ripple">
            <i class="mdui-list-item-icon mdui-icon material-icons">move_to_inbox</i>
            <div class="mdui-list-item-content"><a href="/users/user/">首页</a></div>
        </li>

        <?php

            if($isteacher){
                echo("
                
                <li class=\"mdui-subheader\">教师功能</li>
                <li class=\"mdui-list-item mdui-ripple\">
                    <i class=\"mdui-list-item-icon mdui-icon material-icons\">border_right</i>
                    <div class=\"mdui-list-item-content\"><a href='/users/user/set_homework_page.php'>布置作业</a></div>
                </li>
                <li class=\"mdui-list-item mdui-ripple\">
                    <i class=\"mdui-list-item-icon mdui-icon material-icons\">border_right</i>
                    <div class=\"mdui-list-item-content\"><a href='/users/user/homework_page.php'>作业完成情况</a></div>
                </li>
                
                
                ");
            }
            if($isstudent){
                echo("
                
                <li class=\"mdui-subheader\">学生功能</li>
                <li class=\"mdui-list-item mdui-ripple\">
                    <i class=\"mdui-list-item-icon mdui-icon material-icons\">border_right</i>
                    <div class=\"mdui-list-item-content\"><a href='/users/user/homework_center_page.php'>作业中心</a></div>
                </li>
                
                
                ");
            }
        
        ?>
        
        <!--<li class="mdui-subheader">友链</li>
        <li class="mdui-list-item mdui-ripple">-->
        <!--<i class="mdui-list-item-icon mdui-icon material-icons">email</i>
        <div class="mdui-list-item-content">All mail</div>
        </li>
        <li class="mdui-list-item mdui-ripple">
        <i class="mdui-list-item-icon mdui-icon material-icons">delete</i>
        <div class="mdui-list-item-content">Trash</div>
        </li>
        <li class="mdui-list-item mdui-ripple">
        <i class="mdui-list-item-icon mdui-icon material-icons">error</i>
        <div class="mdui-list-item-content">Spam</div>
        </li>-->
    </ul>
    </div>

</body>
</html>

