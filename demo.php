<?php
/**
* oAuth2.0网页授权测试页
*  
* @author sxfenglei
* @email sxfenglei@vip.qq.com 
*/
require_once 'lib/WxOauth.class.php';

//获取code
if(!isset($_GET['code']) && empty($_GET['code'])){
	echo '用户未授权';
	exit;
} 
//认证服务号
define('APPID','你的认证服务号APPID');
define('SECRET','你的认证服务号APPSECRET');
define('CODE',$_GET['code']);
$wx = new WxOauth(APPID,SECRET,CODE);
//$res = $wx->getOpenid();
$res = $wx->getUserinfo();
var_dump($res);
?>