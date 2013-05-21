<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>文件列表下载</title>

    <style>
        *{
            padding: 0;
            margin: 0;
        }

        a{
            color: black;
            text-decoration: none;
        }
    </style>


</head>

<body>



    <a href="file_upload.html">上传文件</a>
    <br>
    <br>
    <br>




    <ul>
        <?php output_file_list(); ?>
    </ul>
     





    <iframe id="frame1" style="display:none"></iframe>
    <!-- 待会我们把这个iframe的src切换一下, 达到访问特定网址的效果. -->




    <script>

        // 函数负责接受iframe的id, 文件的路径, 文件的名字
        // 然后把iframe的src改成get方式访问一个文件, 然后把[路径]跟[名字]发过去
        // 再后台处理一下就可以下载了
        function populateIframe(id,path,name) 
        {
            var ifrm = document.getElementById(id);
            // 拿到该id的元素
            ifrm.src = "process_file_download.php?path="+path+"&name="+name;
            // 给元素设src
        }

    </script>




</body>
</html>

















<?php


    function output_file_list(){



        // 1. 链接MySQL
        $conn = mysql_connect("localhost","root","");
        // 函数说明: http://www.w3school.com.cn/php/func_mysql_connect.asp
        // 参数说明: 服务器地址, 数据库的用户名, 数据库的密码
        // 函数返回值: 失败返回false 

        if(!$conn){
            die("连接失败".mysql_error());      
        }


        // 2. 选择数据库
        mysql_select_db("file_download");  
        mysql_query("set names utf8");  // 设置一下编码, 确保后面操作中文的时候不会出错.



        // 3. 拿数据.
            // 3.1 构造sql语句
            $sql = "select * from file";
            // 3.2 执行sql语句
            $res = mysql_query($sql,$conn) or die(mysql_error());



        while($row = mysql_fetch_assoc($res)){
            $id = $row['id'];
            $name = $row['name'];
            $path = $row['path'];
        ?>  
            <li>
                <a href="javascript:populateIframe('frame1', '<?php echo $path; ?>', '<?php echo $name; ?>')">
                    <?php echo $name; ?>
                </a>
            </li>
        <?php

        }


        // 最后, 关闭链接
        mysql_close($conn); 


    }


?>