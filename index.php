<?php
define('APPID','你的认证服务号APPID');
$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".APPID."&redirect_uri=http://www.sxfenglei.com/demo.php&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
?>
<!DOCTYPE HTML>
<html>
 <head>
  <title> 测试 </title>
  <meta charset="utf-8" /> 
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">  
 </head>

 <body>
  <a href="<?=$url;?>">点击进行授权</a> 
 </body>
</html>
