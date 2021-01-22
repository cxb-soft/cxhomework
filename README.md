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

### 学生端

1. 输入学生账号登录

2. 在“作业中心”中进入作业选择页面

   ![](https://ftp.bmp.ovh/imgs/2021/01/736a3397ef7266b2.png)
   
3. 点击未完成的作业后进入答题卡

   ![](https://ftp.bmp.ovh/imgs/2021/01/a5c059fc3fc105e9.png)

4. 选择、填写答案并提交

   

### 教师端

1. 输入教师账号登录

#### 布置作业

1. 点击登录后首页的"布置作业",并输入答案及分值

   ![](https://ftp.bmp.ovh/imgs/2021/01/39b2dc448e8491fe.png)

   Tip 练习名中不可包含中文
   
   Tip 答案及分值说明:

​		选择题答案统一使用大写字母，答案之间用英文逗号(,)隔开

​		非选择题答案之间用英文逗号隔开

​		分值设置：

​			不同的分值之间用|符号隔开，第一个数字是开始题号，第二个数字是结束题号，第三个数字是在此区间内的分值

2. 点击“布置”按钮完成作业布置

#### 作业完成情况

1. 点击“作业完成情况”并选择相关作业

2. 查看作业完成情况

   ![](https://ftp.bmp.ovh/imgs/2021/01/e1ea87a487d93789.png)

---

#### THE END

>  #### Contact
>
> QQ : [3319066174](http://wpa.qq.com/msgrd?v=3&uin=3319066174&site=qq&menu=yes)
>
> Email : [cxbsoft@bsot.cn](mailto:cxbsoft@bsot.cn)
>
> Telegram : [@cxbsoft](https://t.me/cxbsoft)



