<?php
/**
* oAuth2.0网页授权
*
* 1、具有微信的oAuth2.0权限 认证的服务号
* 2、配置oAuth2.0的回调域名 不带http or https 
*  配置回调域名注意：www.sxfenglei.com 和 sxfenglei.com是2个不同的域 www.sxfenglei.com并不属于sxfenglei.com  
* @author sxfenglei
* @email sxfenglei@vip.qq.com
*
* 事例:
* require_once 'WxOauth.class.php';
* define('APPID','xxxxxx');
* define('SECRET','xxxxxx');
* define('CODE',$_GET['code']);
* $wx = new WxOauth(APPID,SECRET,CODE);
* //$res = $wx->getOpenid();
* $res = $wx->getUserinfo();
* var_dump($res);
*/
class WxOauth{
	private $appid;
	private $appsecret; 
	private $code;
	private $access_token;
	private $openid; 
	private $userinfo;
 
	/**
	* 初始化 需要APPID 、 APPSECRET 和 CODE
	* 特别注意这个CODE是通过页面“点击”触发 get请求后传递给回调的 好像不能通过curl get触发
	*/
	public function __construct($appid,$appsecret,$code){
		if(empty($appid) || empty($appsecret)||empty($code)){
			die('init fail');
		}
		//appid and appsecret
		$this->appid = $appid;
		$this->appsecret = $appsecret;
		
		//code
		if(empty($code)){ 
			die('parameter error');
		}
		$this->code = $code;

		//cURL
		require_once 'function.inc.php';
	}
 
	/*
	* post 获取openid
	* 获取 CODE有两种方式：
	* snsapi_base不用用户“确认”但只能获取openid
	* snsapi_userinfo 需要用户“确认”但可以获取openid 和 用户信息
	*/
	public function getOpenid($scope="snsapi_base"){   
		//code换取access_token
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?";
		$arr = array(
			'appid'=>$this->appid,
			'secret'=>$this->appsecret,
			'code'=>$this->code,
			'grant_type'=>'authorization_code'
		);

		$dataArr = json_decode(postCurl($url,$arr),true);
		$this->access_token = $dataArr['access_token'];
		$this->openid = $dataArr['openid'];
		if($scope=="snsapi_base"){
			return $dataArr['openid'];  
		}else{
			return $dataArr;  
		}
	}

	/**
	* get 获取userinfo
	*/
	public function getUserinfo(){
		//code获取access_token票据
		$res = $this->getOpenid("snsapi_userinfo");
		$this->access_token = $res['access_token'];
		//access_token换取用户信息
		/*
		$url = "https://api.weixin.qq.com/sns/userinfo?";
		$postArr = array(
			'access_token'=>$this->access_token,
			'openid'=>$this->openid,
			'lang'=>'zh_CN'
		); 
		$this->userinfo = json_decode(postCurl($url,$postArr),true);
		*/
		$url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$this->access_token."&openid=".$this->openid."&lang=zh_CN";
		$this->userinfo = json_decode(getCurl($url),true);
		return $this->userinfo;
	}

	/**
	* get 验证access_token是否有效
	*/
	public function isValidAccessToken($access_token){
		if(empty($access_token)){
			die('The access_token cannot be empty');
		}
		$url = "https://api.weixin.qq.com/sns/auth?access_token=".$access_token."&openid=".$this->openid; 
		$res = json_decode(getCurl($url),true);
		if($res['errcode'] == 0){
			return true;
		}else{
			return false;
		}
	}

	/**
	* post 刷新access_token
	*/
	public function refreshAccessToken($refresh_token){
		if(empty($refresh_token)){
			die('The refresh_token cannot be empty');
		}
		//$url = "appid=".$this->openid."&grant_type=refresh_token&refresh_token=".$refresh_token; 
		//$res = json_decode(getCurl($url),true);
 
		$url = "https://api.weixin.qq.com/sns/oauth2/refresh_token?";
		$arr = array(
			'appid'=>$this->appid,
			'grant_type'=>'refresh_token',
			'refresh_token'=>$refresh_token
		);

		$res = json_decode(postCurl($url,$arr),true);
 
		return $res; 
	}
} 


?>