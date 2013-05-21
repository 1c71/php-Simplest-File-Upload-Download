<?php

    // $_FILES是超全局变量, 你可以用var_dump输出看看.
    // var_dump($_FILES); exit;
    // 加了个exit; 是为了不执行后面的代码. 
    

    

    if(!isset($_FILES['file']['tmp_name']))
    {
        exit;
    }
    // 没接收到文件的话, 直接退出










    // ==== 1. 根据error值判断是否出错, 出错就不处理了 ====
    if ( $_FILES['file']['error'][0] != 0 ){
        echo "上传 ".$_FILES['file']['name'][0]." 失败.";
        exit;
    }




    // ==== 2. 获得文件大小 ====

    /*
        思路:
            获得文件大小
            太大就拒绝处理

    */

    $bytesize = $_FILES['file']['size'][0];    
    // 这个值是字节, 也就是byte, 缩写b
    // 1M = 1024 kb
    // 1kb = 1024 b


    // 如果文件大小超过5G
    // 我们就提示太大, 不继续执行了.
    if( $bytesize > 1024*1024*1024*5 ){ 
        echo "文件 ".$_FILES['file']['name'][0]." 大小超过5G, 上传失败. <br/>";
        exit;
    }




    // ==== 3. 移动文件到file/目录下 ====
    
    /*
        思路:
            拿到文件原名 (检测是否为空, 为空跳过不处理)
            拿到文件后缀 (检测是否有后缀, 没有后缀就跳过不处理)
            创建个随机文件名, 确保不会重复, 如果有不同的2个用户上传同名的文件, 就不会互相覆盖了
            分目录处理
            用move_uploaded_file来处理, 把文件从临时存放的地点, 移动到我们想存的目录里
            最后把数据存到数据库里

    */
                
    $name = $_FILES['file']['name'];
    // 文件原名

    if(!$name){
        // 如果后缀为空我们就不处理这个文件
        echo "有文件的文件名为空, 上传失败(既然文件名为空 我也没法告诉你哪个文件名为空对吧..).";
        exit;       
    }




    $ext = pathinfo($name, PATHINFO_EXTENSION);
    // 文件后缀
    // 示例: $ext = pathinfo("333.php", PATHINFO_EXTENSION);
    // 输出: php
    // 假设你输出的字符是 'aaaaa', 那么这个函数获取不到后缀名,  返回空字符串

    if(!$ext){
        // 如果后缀为空我们就不处理这个文件
        echo "文件 ".$name." 没有后缀, 上传失败.";
        exit;
    }



        

    $random_name = time().rand(1,10000).rand(1,10000).rand(1,10000).'.'.$ext;
    // 随机文件名 = 随机数字+原文件的后缀




    /*** 开始分目录处理 ***/
    $today = date("Y-m-d");
    // 拿到今天的日期, 格式是年-月-日, 用于创建文件夹
    // 举例: 2013-5-16


    $time_dir = 'file/'.$today.'/';
    // 存放目录 = file/ + 今天的日期
    // 举例: file/2013-5-16/

    if (!file_exists($time_dir)) {
        mkdir($time_dir, 0777, true);
    }
    // 如果这个文件夹不存在, 那就创建这个文件夹



    // 根据文件后缀判断类型. 一共有几个类型请去参阅plan.txt
    if($ext=='doc' || $ext=='xls' || $ext=='txt' || $ext=='pdf' || $ext=='ass' || $ext=='srt'){
        // 文本文件
        $classify = 'text';
    }
    else if ( $ext=='png' || $ext=='jpg' || $ext=='gif' || $ext=='bmp' || $ext=='psd'){
        // 图片
        $classify = 'image';
    }
    elseif($ext=='rmvb' || $ext=='mp4' || $ext=='avi' || $ext=='wmv' || $ext=='flv'){
        // 视频
        $classify = 'video';
    }
    elseif($ext=='mp3' || $ext=='aif' || $ext=='aiff'){
        // 音频
        $classify = 'audio';
    }
    elseif($ext=='rar' || $ext=='zip' || $ext=='7z'){
        // 压缩包
        $classify = 'zip';
    }
    else{
        $classify = 'other';
    }

    

    // 现在我们在对应文件夹下面创建分类目录
    $classify_dir = $time_dir.$classify.'/';

    if (!file_exists($classify_dir)) {
        mkdir($classify_dir, 0777, true);
    }



    $file_store_path = $classify_dir.$random_name;
    // 文件的全存放路径 = 日期/分类/存放目录+随机文件名



    // move_uploaded_file函数 第1个参数是上传文件的临时位置, 第2个是文件新位置.
    if ( move_uploaded_file($_FILES['file']['tmp_name'], $file_store_path) ) {



        // ==== 4. 把文件数据 插入到数据库 ==== 


        $conn = mysql_connect("localhost","root","");
        // mysql_connect 函数如果成功，则返回一个 MySQL 连接标识，失败则返回 FALSE。
        // http://www.w3school.com.cn/php/func_mysql_connect.asp

        if(!$conn){
            die("连接失败".mysql_error());      
        }


        mysql_select_db("file_download");  //选择数据库
        mysql_query("set names utf8");


        $sql = "insert into file (path,name) values('$file_store_path','$name');";


        mysql_query($sql,$conn) or die(mysql_error());
        mysql_close($conn); //关闭链接


        header('Location: index.php');
        // 把用户送回首页.


    } else {
        exit;
    }







// ============================================================================
/*

    关于$_FILES['file']['error']报错信息说明：
     
    值：0; 没有错误发生，文件上传成功。   
    值：1; 上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值。   
    值：2; 上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值。   
    值：3; 文件只有部分被上传。   
    值：4; 没有文件被上传.  

*/

?>