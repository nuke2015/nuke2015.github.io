<?php
if(!defined("Maxhom")) exit("Access Denied");
class OauthAction extends FrontAction
{
	public function index($type ='qq'){
		$type=strtolower($_REQUEST['type']);
		$typeall=array('qq','sina','twiter','facebook');
		if(!in_array($type,$typeall))$this->error('非法参数!');

		//加载ThinkOauth类并实例化一个对象
		import("@.Oauth.ThinkOauth");
		$sns  = ThinkOauth::getInstance($type); //实例化;
		//跳转到授权页面
		redirect($sns->getRequestCodeURL()); //直接授权,根据配置返回到callback
	}
	
	//授权回调地址
	public function callback($type = null, $code = null){
		(empty($type) || empty($code)) && $this->error('参数错误');
		
		//加载ThinkOauth类并实例化一个对象
		import("@.Oauth.ThinkOauth");
		$sns  = ThinkOauth::getInstance($type); //实例化;

		//腾讯微博需传递的额外参数
		$extend = null; //特殊处理;
		if($type == 'tencent'){
			$extend = array('openid' => $this->_get('openid'), 'openkey' => $this->_get('openkey'));
		}

		//请妥善保管这里获取到的Token信息，方便以后API调用
		//调用方法，实例化SDK对象的时候直接作为构造函数的第二个参数传入
		//如： $qq = ThinkOauth::getInstance('qq', $token);
		$token = $sns->getAccessToken($code , $extend); //根据code取token;

		//获取当前登录用户信息
		if(is_array($token)){
			$data = A('Type','Event')->$type($token);
			S(sid('oauth'),$data,86400); //缓存数据;
			#dump($data);exit; //测试拦截;
			if($this->checkuser($data)){
				$this->login($data); //有资料
			}else{
				$this->data=$data;
				$this->display('reg');//补充资料;
			}
		}
	}
	
	#检查是否新用户;
	private function checkuser($data){
		$username=$data['username'];
		$model=D('user');
		if($model->getByUsername($username)){
			return true;
		}else{
			return false;
		}
	}
	
	#登陆行为;
	private function login($data){
		$this->dao=D('User');
		$authInfo=$this->dao->getByUsername($data['username']);
        if(empty($authInfo)){
            $this->error(L('empty_userid')); //用户不存在;
        }else{
			$cookietime = 3600; //默认cookie为一小时;
			$maxhom_auth_key = sysmd5($this->sysConfig['ADMIN_ACCESS'].$_SERVER['HTTP_USER_AGENT']);
			$maxhom_auth = authcode($authInfo['id']."-".$authInfo['groupid']."-".$authInfo['password'], 'ENCODE', $maxhom_auth_key);
			#cookie跟踪;
			cookie('auth',$maxhom_auth,$cookietime);
			cookie('username',$authInfo['username'],$cookietime);
			cookie('realname',$authInfo['realname'],$cookietime);
			cookie('groupid',$authInfo['groupid'],$cookietime);
			cookie('userid',$authInfo['id'],$cookietime);
			cookie('email',$authInfo['email'],$cookietime);

            //保存登录信息
			$dao = M('User');
			$data = array();
			$data['id']	=	$authInfo['id'];
			$data['last_logintime']	=	time();
			$data['last_ip']	=	 get_client_ip();
			$data['login_count']	=	array('exp','login_count+1');
			$dao->save($data);
			
 			$forward = U('Home/index/index');	
			$this->assign('jumpUrl',$forward);
			$this->success(L('login_ok'));
		}
	}

	#注册行为+表单;
	public function reg(){
		$data=S(sid('oauth'));
		#有补充资料时;
		if($_POST && $data){
			$p=get_safe_replace($_POST);
			$data['email']=$p['email'];
			$data['mobile']=$p['mobile'];
			$data['web_url']=$p['web_url'];
			$data['address']=$p['address'];
			$data['groupid']=3;
			$data['login_count']=1;
			$data['createtime']=time();
			$data['updatetime']=time();
			$data['last_logintime']=time();
			$data['reg_ip']=get_client_ip();
			$data['status']=1;
			$this->reg_check($data);
		}
	}
	#邮件验证;
	private function reg_check($data){
		$this->dao=D('User');
		if($r=$this->dao->create($data)){
			if(false!==$this->dao->add()){
				$authInfo['id'] = $uid=$this->dao->getLastInsID();
				$authInfo['groupid'] = $ru['role_id']=$data['groupid'];
				$ru['user_id']=$uid;
				$roleuser=M('RoleUser');
				$roleuser->add($ru);

				if($this->member_config['member_emailcheck']){
					$maxhom_auth = authcode($uid."-".$username."-".$email, 'ENCODE',$this->sysConfig['ADMIN_ACCESS'],3600*24*3);//3天有效期
					$url = 'http://'.$_SERVER['HTTP_HOST'].U('User/Login/regcheckemail?code='.$maxhom_auth);
					$click = "<a href=\"$url\" target=\"_blank\">".L('CLICK_THIS')."</a>";
					$message = str_replace(array('{click}','{url}','{sitename}'),array($click,$url,$this->Config['site_name']),$this->member_config['member_emailchecktpl']);
					$r = sendmail($email,L('USER_REGISTER_CHECKEMAIL').'-'.$this->Config['site_name'],$message,$this->Config);
					$this->assign('send_ok',1);
					$this->assign('username',$username);
					$this->assign('email',$email);
					$this->display('Login:emailcheck');
					exit;
				}
				
				$maxhom_auth_key = sysmd5($this->sysConfig['ADMIN_ACCESS'].$_SERVER['HTTP_USER_AGENT']);
				$maxhom_auth = authcode($authInfo['id']."-".$authInfo['groupid']."-".$authInfo['password'], 'ENCODE', $maxhom_auth_key);
				

				$authInfo['username'] = $data['username'];
				$authInfo['email'] = $data['email'];
				cookie('auth',$maxhom_auth,$cookietime);
				cookie('username',$authInfo['username'],$cookietime);
				cookie('realname',$authInfo['realname'],$cookietime);
				cookie('groupid',$authInfo['groupid'],$cookietime);
				cookie('userid',$authInfo['id'],$cookietime);
				cookie('email',$authInfo['email'],$cookietime);

				$this->success('自动注册成功!',U('Index/index'));
			}else{
				$this->error('自动注册失败!');
			}
		}else{
			$this->error($this->dao->getError());
		}
	}

	#fetch方法;
	protected function http($url,$params,$method = 'GET', $header = array()){
		$vars = http_build_query($params);
		$opts = array(
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_HTTPHEADER     => $header
		);

		/* 根据请求类型设置特定参数 */
		switch(strtoupper($method)){
			case 'GET':
				$opts[CURLOPT_URL] = $url . '?' . $vars;
				break;
			case 'POST':
				$opts[CURLOPT_URL] = $url;
				$opts[CURLOPT_POST] = 1;
				$opts[CURLOPT_POSTFIELDS] = $vars;
				break;
			default:
				throw new Exception('不支持的请求方式！');
		}
		
		/* 初始化并执行curl请求 */
		$ch = curl_init();
		curl_setopt_array($ch, $opts);
		$data  = curl_exec($ch);
		$error = curl_error($ch);
		curl_close($ch);
		if($error) 
			throw new Exception('请求发生错误：' . $error);
		return  $data;
	}
	
	#FACEBOOK;
	public function facebook(){
		$config = C("THINK_SDK_FACEBOOK"); //读取配置;
		$app_id = $config['APP_KEY'];
		$app_secret = $config['APP_SECRET'];
		$my_url = $config['CALLBACK'];
		$_SESSION['state'] = md5(uniqid(rand(),TRUE));//csrf;
		if($_GET['init']){
			$dialog_url = "https://www.facebook.com/dialog/oauth?client_id=";
			$dialog_url.=$app_id."&redirect_uri=".urlencode($my_url);
			$dialog_url.='&state='.$_SESSION['state'];
			
			header("Location: ".$dialog_url); //去认证;
		}else{
			$code = $_GET['code']; //回调code码;

			$token_url = "https://graph.facebook.com/oauth/access_token?client_id=";
			$token_url.=$app_id."&redirect_uri=".urlencode($my_url);
			$token_url.="&client_secret=".$app_secret."&code=".$code."&state".$_SESSION['state'];
			
			$response = $this->http($token_url);
			parse_str($response,$param); // 解析出acces_token和expires

			$graph_url="https://graph.facebook.com/me?access_token=";
			$graph_url.=$param['access_token']."&state=".$_SESSION['state']; //csrf;
			
			$response = $this->http($graph_url);//json对象;
			$user = json_decode($this->http($graph_url));
			if(!$user->id)$this->error("授权失败,请稍候再试!",U('Index/Index'));
			#数据组装;
			$data['username']='FACEBOOK_'.$user->id; //用户ID;
			$data['realname']=$user->name;
			$data['sex']=($data['gender']=='male')?1:2; //1男2女
			$data['status']=1;
			$data['password']=sysmd5(rand_string());

			S(sid('oauth'),$data,86400); //缓存数据;
			if($this->checkuser($data)){
				$this->login($data); //有资料
			}else{
				$this->data=$data;
				$this->display('reg');//补充资料;
			}
		}
	}
	
	#Twiter
	public function twiter(){
		import("@.Twiter.TwitterOAuth"); //引入官方类库;
		include APP_PATH.'/Lib/Twiter/OAuth.php';
		
		$config = C("THINK_SDK_TWITER"); //读取配置;
		$app_id = $config['APP_KEY'];
		$app_secret = $config['APP_SECRET'];
		$my_url = $config['CALLBACK'];
		
		if($_GET['init']){
			/* Build TwitterOAuth object with client credentials. */
			$conn = new TwitterOAuth($app_id,$app_secret);
			/* Get temporary credentials. */
			$tokens = $conn->getRequestToken($my_url); //回调地址
			S('twiter',$tokens,10); //缓存code码;
			//这里需要进行单用户区分,但是一直传不过去.
		
			$dialog_url = $conn->getAuthorizeURL($tokens['oauth_token']);
			header('Location: '.$dialog_url); //去认证; 
		}else{
			$tokens=S('twiter');
			$conn = new TwitterOAuth($app_id,$app_secret,$tokens['oauth_token'],$tokens['oauth_token_secret']);
			$access_token = $conn->getAccessToken($_REQUEST['oauth_verifier']);

			$conn2 = new TwitterOAuth($app_id,$app_secret,$access_token['oauth_token'],$access_token['oauth_token_secret']);
			$user=$conn2->get('account/verify_credentials');
			if(!$user->id)$this->error("授权失败,请稍候再试!",U('Index/Index'));			
			#数据组装;
			$data['username']='TWITER_'.$user->id; //用户ID;
			$data['realname']=$user->name; //用户名;
			$data['sex']=0; //无,twiter不关心个人性别;
			$data['avatar']=$user->profile_image_url; //无,twiter不关心个人性别;
			$data['status']=1;
			$data['password']=sysmd5(rand_string()); //密码随机,永远不会用到.

			S(sid('oauth'),$data,86400); //缓存个人数据;
			if($this->checkuser($data)){
				$this->login($data); //有资料
			}else{
				$this->data=$data;
				$this->display('reg');//补充资料;
			}
		}
	}
}