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
            echo("You are not a teacher .");
            header("location:/users/user/");
            exit();
        }
        $_SESSION['isteacher'] = $isteacher;
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
    <title><?php echo(WEBSITE) ?> 布置作业</title>
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
            <a href="javascript:;" class="mdui-typo-title">布置作业 - <?php echo($username) ?></a>
            <div class="mdui-toolbar-spacer"></div>
            <!--<a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">search</i></a>
            <a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">refresh</i></a>
            <a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">more_vert</i></a>-->
            <button class="mdui-btn mdui-btn-raised mdui-ripple" onclick="unlogin()">退出登录</button>
        </div>
    </div>

    <div style="padding:20px">
    
        <div class="mdui-textfield">
            <label class="mdui-textfield-label">练习名</label>
            <input class="mdui-textfield-input" type="text" id="test_name" />
        </div>

        <div class="mdui-textfield">
            <label class="mdui-textfield-label">选择题答案</label>
            <input class="mdui-textfield-input" type="text" id="select_answer" />
        </div>
        
        <div class="mdui-textfield">
            <label class="mdui-textfield-label">选择题分值</label>
            <input class="mdui-textfield-input" type="text" id="select_answer_score" />
        </div>

        <div class="mdui-textfield">
            <label class="mdui-textfield-label">非选择题答案(英文逗号隔开)</label>
            <input class="mdui-textfield-input" type="text" id="answer" />
        </div>

        <div class="mdui-textfield">
            <label class="mdui-textfield-label">非选择题答案分值</label>
            <input class="mdui-textfield-input" type="text" id="answer_score" />
        </div>

        <br>

        <button class="mdui-btn mdui-btn-raised mdui-ripple" onclick="set_homework()">布置</button>
    
    </div>

    <script>
        function toggle(){
            var inst = new mdui.Drawer('#drawer');
            inst.toggle();
        }

        function set_homework(){
            test_name = $("#test_name").val()
            select_answer = $("#select_answer").val()
            answer = $("#answer").val()
            select_answer_score = $("#select_answer_score").val()
            answer_score = $("#answer_score").val()
            $.ajax({
             type: "POST",
             url: "/users/user/set_homework.php",
             data: {
                 test_name : test_name,
                 select_answer : select_answer,
                 answer : answer,
                 select_answer_score : select_answer_score,
                 answer_score : answer_score
             },
             dataType: "text",
             success: function(data){
                 console.log(data)
                 if(data == 3000){
                    mdui.snackbar({
                        message: '作业已布置',
                        position: 'left-top'
                    });
                 }
                 else{
                     if(data == 3001){
                        mdui.snackbar({
                            message: '作业存在',
                            position: 'left-top'
                        });
                     }
                 }
             }
            })

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