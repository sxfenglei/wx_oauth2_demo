<?php
/**
* @title 公共函数 
* @author sxfenglei
* @email sxfenglei@vip.qq.com 
*/

/**
* get curl 函数
* $url = "http://www.sxfenglei.com/get.php?name=小小冯同学&age=30";
*/
function getCurl($url=''){
	if(empty($url)){
		return false;
	} 
	$url = trim($url);
    $curl = curl_init(); 
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);//设置不带头文件
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//设置获取的信息以文件流的形式返回 
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);//curl https ssl
    $output = curl_exec($curl);  
	if($output === false){
		echo 'cURL Error:'.curl_error($curl);
	}
    curl_close($curl);
	return $output;
}

/**
* post curl 函数
* $url = "http://www.sxfenglei.com/post.php";
* $data = array('name'=>'小小冯同学','age'=>30);
*/
function postCurl($url='',$data=array()){
	if(empty($url)){
		return false;
	} 
    $url = trim($url);
    $curl = curl_init(); 
    curl_setopt($curl, CURLOPT_URL, $url); 
    curl_setopt($curl, CURLOPT_HEADER, 0); //设置不带头文件
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//设置获取的信息以文件流的形式返回 
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);//curl https ssl
    curl_setopt($curl, CURLOPT_POST, 1);//设置post方式提交 
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); //设置post数据
    $output = curl_exec($curl);  
	if($output === false){
		echo 'cURL Error:'.curl_error($curl);
	}
    curl_close($curl);
	return $output;
}
