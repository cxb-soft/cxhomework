<?php

    require_once("functions.php");
    
    session_start();
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $per = $_SESSION['per'];
    $isstudent = $_SESSION['isstudent'];
    $isteacher = $_SESSION['isteacher'];
    $user = new user($username);
    $login = $user -> login($password);
    $login_code = $login['code'];
    if($login_code == 200){
        $detail = $login['detail'];
        $per = $detail['per'];
        $classname = $detail['classname'];
    }
    else{
        echo("Please login first.");
        header("location:/");
        exit();
    }

?>


<?php
    
    $homework = new homework($test_name="",$username=$username);
    $homeworks = $homework -> get_all_homework($classname);
    $homeworks = $homeworks['detail'];

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

    <div style="padding-left:10%;padding-right:10%;padding-top:5%">
        <h3>未完成</h3>
        <div class="mdui-divider"></div>
        <ul class="mdui-list">
        
        <?php
        
            foreach($homeworks as $homework_item){
                $test_name = $homework_item[0];
                $test_id = $homework_item[1];
                $state = $homework_item[8];
                if($state == "false"){
                    echo("
            
                    <a mdui-tooltip=\"{content: '完成作业'}\" href='javascript:go_homework(\"$test_id\");'><li class=\"mdui-list-item mdui-ripple\">
                        <i class=\"mdui-list-item-icon mdui-icon material-icons\">move_to_inbox</i>
                        <div class=\"mdui-list-item-content\">$test_name</div>
                    </li></a>
                    
                    ");
                }
            }
        
        ?>
        </ul>
    </div>

    <div style="padding-left:10%;padding-right:10%;padding-top:5%">
        <h3>已完成</h3>
        <div class="mdui-divider"></div>
        <ul class="mdui-list">
        
        <?php
        
            foreach($homeworks as $homework_item){
                $test_name = $homework_item[0];
                $test_id = $homework_item[1];
                $state = $homework_item[8];
                if($state == "true"){
                    echo("
            
                    <a mdui-tooltip=\"{content: '查看作业'}\" href='javascript:;'><li class=\"mdui-list-item mdui-ripple\">
                        <i class=\"mdui-list-item-icon mdui-icon material-icons\">move_to_inbox</i>
                        <div class=\"mdui-list-item-content\">$test_name</div>
                    </li></a>
                    
                    ");
                }
            }
        
        ?>
        </ul>
    </div>

    <script>
        function toggle(){
            var inst = new mdui.Drawer('#drawer');
            inst.toggle();
        }
        function go_homework(test_id){
            console.log(test_id)
            window.location = "/users/user/homework_sub.php?test_id=" + test_id
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
    <style>
        #footer {
                height: 40px;
                line-height: 40px;
                position: fixed;
                bottom: 0;
                width: 100%;
                text-align: center;
                background: #333;
                color: #fff;
                font-family: Arial;
                font-size: 12px;
                letter-spacing: 1px;
            }
    </style>
    <div id="footer" class="mdui-typo">Copyright©2014-2021 <a href="//blog.bsot.cn">cxbsoft</a> All Rights Reserved</div>

</body>
</html>