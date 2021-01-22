<?php

    require_once("functions.php");

    session_start();
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
            <a href="javascript:;" class="mdui-typo-title">用户中心 - <?php echo($username) ?></a>
            <div class="mdui-toolbar-spacer"></div>
            <!--<a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">search</i></a>
            <a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">refresh</i></a>
            <a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">more_vert</i></a>-->
            <button class="mdui-btn mdui-btn-raised mdui-ripple" onclick="unlogin()">退出登录</button>
        </div>
    </div>

    <script>
        function toggle(){
            var inst = new mdui.Drawer('#drawer');
            inst.toggle();
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

    <h3>你好,<?php echo($username) ?></h3>

</body>
</html>

