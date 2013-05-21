<?php
    
    if(!$_GET['path'] || !$_GET['name']){
        header("HTTP/1.1 404 Not Found"); 
        exit;
    }
    // 我们用get方式获取到文件的路径和名字, 如果参数不完整, 直接退出




    $name = $_GET['name'];
    $path = $_GET['path'];
    // 如果完整, 就会运行到这里, 我们拿这2个参数保存到这2个变量里, 免得总是要写$_GET['xxx']




    if( !file_exists($path) ){
        header("HTTP/1.1 404 Not Found"); 
        exit;
    }
    // 判断文件是否存在, 如果不存在, 退出. 没必要进行下去了








// ==== 开始让用户下载文件了 ====



    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=".$name);



    
    $fp = fopen($path,"r");
    // 打开文件
    
    $file_size = filesize($path);
    // 获取下载文件的大小


    $buffer = 1024;
    // buffer变量保存我们每次读取多少个字节, 这里我们每次读1024个字节

    $file_count = 0;
    // 记录我们已经读取了多少个字节, 判断文件究竟读完没有






    // 用feof判断看看有没有读取到末尾 and 并且利用文件大小来没读取完
    // 这里是双重保险
    // 如果文件没读取完, 就一直读取并输出
    while(!feof($fp) && $file_size-$file_count>0 ) {

        echo fread($fp,$buffer);
        // 读取$buffer个字节大小, 并输出.

        $file_count += $buffer;
        // 记录一下刚刚我们读取了这么多个字节.

    }




    fclose($fp);
    // 关闭文件


?>