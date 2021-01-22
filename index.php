<!DOCTYPE html>
<?php

    require_once("users/config.php");
    

?>

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
    <div class="mdui-appbar">
    <div class="mdui-toolbar mdui-color-theme">
        <a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">menu</i></a>
        <a href="javascript:;" class="mdui-typo-title">CX HOMEWORK</a>
        <div class="mdui-toolbar-spacer"></div>
        <a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">search</i></a>
        <a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">refresh</i></a>
        <a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">more_vert</i></a>
    </div>
    </div>

    <center>
        <h2>欢迎来到 <?php echo(WEBSITE) ?>作业平台</h2>
    </center>

    <div class="mdui-divider"></div>
    <div style="padding:20px">
        <h2>登录</h2>
        <div class="mdui-textfield">
            <label class="mdui-textfield-label">用户名</label>
            <input class="mdui-textfield-input" type="text" id="username" />
        </div>
        <div class="mdui-textfield">
            <label class="mdui-textfield-label">密码</label>
            <input class="mdui-textfield-input" type="password" id="password" />
        </div>
        <br>
        <button class="mdui-btn mdui-btn-raised mdui-ripple" onclick="login()">登录</button>
    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/mdui@1.0.1/dist/js/mdui.min.js"
        integrity="sha384-gCMZcshYKOGRX9r6wbDrvF+TcCCswSHFucUzUPwka+Gr+uHgjlYvkABr95TCOz3A"
        crossorigin="anonymous"
    ></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script>
        function login(){
            var username = $("#username").val();
            var password = $("#password").val();
            $.ajax({
             type: "POST",
             url: "/users/login/login.php",
             data: {
                 username : username,
                 password : password
             },
             dataType: "text",
             success: function(data){
                 if(data=="success"){
                    mdui.snackbar({
                        message: '登录成功,即将跳转...',
                        position: 'left-top'
                    });
                    setTimeout(() => {
                        window.location="/users/user/index.php"
                    }, 2000);
                 }
                 else if(data==1001){
                    mdui.snackbar({
                        message: '没有找到此账户',
                        position: 'left-top'
                    });
                 }
                 else if(data==1002){
                    mdui.snackbar({
                        message: '密码错误',
                        position: 'left-top'
                    });
                 }
             }
            })
        }
    </script>
</body>
</html>


<?php


?>