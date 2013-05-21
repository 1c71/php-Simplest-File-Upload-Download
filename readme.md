


##### 这个是最简单的文件上传下载系统,  

##### 一共就 4个文件+3个目录 (其中俩目录还是可以删掉的..) 

##### 放出来 是希望能给想做文件下载和上传的同学们 提供一些参考

##### 语言用的是PHP, 数据库用的是MySQL

<br>

---

### 目录说明:  

<br>
__file/__  
存放用户上传的文件, 可以在process_file_upload.php里面随意设置路径  

<br>
__install/__  
做文件上传和下载当然需要建数据库和表, 这里面是mysql语句,   
需要先运行一下, 创建出表, 不然网站不能用  

<br>
__comment/__  
有关代码的一些长说明, 这些说明放在代码里面不太合适, 实际上这文件夹里就2个文件.
写了 process_file_download.php 和 process_file_upload.php 的一些说明和思路.

<br>
__index.php__          
文件下载页面  
你上传的文件都会在这里列出来, 这个页面默认是空的(因为你都没上传文件呀..)

<br>
__file_upload.php__    
文件上传页面  
可以在这个页面选择文件并上传

<br>
__process_file_download.php__   
处理文件下载

<br>
__process_file_upload.php__     
处理文件上传


<br>

---

### 使用说明:

1. 进入install目录  
(里面就1个database_design.txt文件)  
把这里面的mysql语句运行一下, 创建数据库和1张表

2. 进localhost, 使用这个网站吧~

<br>


---

### 设置说明:

为了做文件上传, php.ini里需要做一些设置

1. upload_max_filesize  
它决定着 上传的文件大小的最大值  
默认2M, 最好修改, 你可以修改成自己想要的限制,  
仅供参考: 我自己设置的是5G  

2. post_max_size  
它决定着 通过POST提交数据的最大值  
仅供参考: 我自己也是设置的5G


<br>
__注意,修改完成后必须重启apache,否则设置不生效__

<br>


---

### 其他说明:

php文件要放在apache里才能运行,  
不要随便放在桌面就尝试运行.  

<br>


你有任何问题, 并且


如果 (你有Github帐号) {  
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [请开个issue](https://github.com/1c7/Simplest_File_Upload_Download_PHP/issues)  
}  
否则 {  
    &nbsp;&nbsp;&nbsp;&nbsp; [可以来我的微博给我留言或私信](http://www.weibo.com/u/2004104451)  
}  


<br>
<br>
<br>

---












