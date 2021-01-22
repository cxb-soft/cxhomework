<?php

    require_once("functions.php");
    session_start();
    $test_id = $_GET['test_id'];
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
    $homework_detail = $homework -> get_homework_by_id($test_id);
    $homework_detail = $homework_detail['detail'];

    $select_answers = $homework_detail['select_answer'];
    $answers = $homework_detail['answer'];

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
            <a href="javascript:;" class="mdui-typo-title">提交作业 - <?php echo($username) ?></a>
            <div class="mdui-toolbar-spacer"></div>
            <!--<a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">search</i></a>
            <a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">refresh</i></a>
            <a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">more_vert</i></a>-->
            <button class="mdui-btn mdui-btn-raised mdui-ripple" onclick="unlogin()">退出登录</button>
        </div>
    </div>



    <div style="padding-top:5%;padding-left:10%;padding-right:10%">
    
        <h2>答题卡</h2>
        <div class="mdui-divider"></div>
        <h3>选择题</h3>
        
        <?php
            $select_answers = explode(",",$select_answers);
            $x = 1;
            foreach($select_answers as $select_answers_item){
                echo("
                
                <label>$x</label>&emsp;
                <select class=\"mdui-select\" id='select_$x' mdui-select=\"{position: 'bottom'}\">
                    <option value=\"A\">A</option>
                    <option value=\"B\">B</option>
                    <option value=\"C\">C</option>
                    <option value=\"D\">D</option>
                    <option value=\"E\">E</option>
                    <option value=\"F\">F</option>
                    <option value=\"G\">G</option>
                </select>
                <br>
                
                ");
                $x += 1;
            }
            $select_num = $x;
        
        ?>
        <h3>非选择题</h3>
        
        <?php
            $answers = explode(",",$answers);
            foreach($answers as $answers_item){
                echo("
                
                <div class=\"mdui-textfield\" style='padding-right:10%'>
                    <label class=\"mdui-textfield-label\">$x</label>
                    <input class=\"mdui-textfield-input\" id=\"answer_$x\" type=\"text\"/>
                </div>
                <br>
                
                ");
                $x += 1;
            }
            $answer_num = $x - $select_num;
        
        ?>
    <button class="mdui-btn mdui-btn-raised mdui-ripple" onclick="sub_homework()">提交答案</button>

    </div>

    <script>
        function toggle(){
            var inst = new mdui.Drawer('#drawer');
            inst.toggle();
        }
        function sub_homework(){
            <?php
                
                $x = 1;
                foreach($select_answers as $select_answers_item){
                    echo("var select_$x = $('#select_$x').val()\n");
                    $x += 1;
                }
                foreach($answers as $answers_item){
                    echo("var answer_$x = $('#answer_$x').val()\n");
                    $x += 1;
                }
                echo("var datago={\ntest_id:'$test_id',\n");
                $x = 1;
                foreach($select_answers as $select_answers_item){
                    echo("select_$x : select_$x,\n");
                    $x += 1;
                }
                foreach($answers as $answers_item){
                    echo("answer_$x : answer_$x,\n");
                    $x += 1;
                }
                echo("}\n");

            ?>

            $.ajax({
                type: "POST",
                url: "/users/user/sub_homework.php",
                data: datago,
                dataType: "text",
                success: function(data){
                    console.log(data)
                    mdui.snackbar({
                        message: '已提交,即将跳转...',
                        position: 'left-top'
                    });
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

