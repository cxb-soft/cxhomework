# CX 作业平台

> 一个作业自动批改批分系统

## 简介

​	CX 作业平台能够实现自动批改作业、题目正确率显示、分数统计等功能

## 安装方法

#### 配置

1. 编辑 ``` /users/config.php ```文件进行数据库配置以及站点名称设置

   ```php
   <?php
   
       const DATABASE_ADDR = "你的数据库地址"; // 这里填写你的数据库地址
       const DATABASE_USERNAME = "你的数据库用户名"; // 这里填写你的数据库用户名
       const DATABASE_PASSWORD = "你的数据库密码"; // 这里填写你的数据库密码
       const DATABASE = "你的数据库名"; // 写数据库名
       const WEBSITE = "CX HOMEWORK"; // 站点名称，用于显示在标题处
       const INITPASS = "123456"; // 设置用户名的初始密码
       const TEACHER_PASS = "admin"; // 教师账号的密码
   	
   
       $db = mysqli_connect(DATABASE_ADDR,DATABASE_USERNAME,DATABASE_PASSWORD,DATABASE); 
   
   ?>
   ```

2. 将根目录下的```homework.sql```导入数据库

#### 关于导入用户数据

​	处于平台应用场景需要，所有的用户名、密码和班级都要自行导入数据库。导入方法如下：

1. 填写要导入的班级的名单```name_list.xlsx```,按照列表中所给的格式填。

2. 编辑```user_import.php```找到

   ```php
   $classname = "班级"; // 这里输入班级
   ```

   这里换成自己的班级名称

3. 转到网站根目录，执行```php user_import.php```将会进行自动导入。

4. 班级对应的教师账号就是 ```$classname```里存放的班级名，密码是在```conifg.php```中放的```TEACHER_PASS```

5. 每个学生的账号就是自己的中文名，密码是在```conifg.php```中放的```INITPASS```



## 食用方法



   

   