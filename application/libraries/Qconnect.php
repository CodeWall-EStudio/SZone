<?
	class qconnect{

	    const VERSION = "2.0";
	    const GET_AUTH_CODE_URL = "https://graph.qq.com/oauth2.0/authorize";
	    const GET_ACCESS_TOKEN_URL = "https://graph.qq.com/oauth2.0/token";
	    const GET_OPENID_URL = "https://graph.qq.com/oauth2.0/me";		
	    const GET_USER_INFO = 'https://graph.qq.com/user/get_user_info';
	    const FILE_PATH = 'E:\myworks\ezone\logs';

		public $appid = '100548719';
		public $appkey = '9e47324ac7fed9f8364d4982ccf3037e';
		public $callback = 'http://szone.codewalle.com/login/callback';
		public $scope = null;
		public $CI;


		public function __construct($props = array()){
			if(!isset($_SESSION)){
			    session_start();
			}
			$this->CI =& get_instance();
			$this->CI->load->library('session');

			$this->initialize($props);

			//log_message('debug', "Upload Class Initialized");
		}		

		public function initialize($config = array()){
			
		}

		public function logmsg($msg){
			$path = self::FILE_PATH.'\\logs';
			error_log(print_r($msg.'\r\n',true),3,$path);
		}

		public function set_error($msg)
		{
			log_message('error', $msg);
			$this->error_msg[] = $msg;
		}		

		public function qq_login(){
	        //-------生成唯一随机串防CSRF攻击
	        $state = md5(uniqid(rand(), TRUE));

	        $this->CI->session->set_userdata('state',$state);
	        $_SESSION['state'] = $state;
	        log_message('debug','state:'.$state);

	        //-------构造请求参数列表
	        $keysArr = array(
	            "response_type" => "code",
	            "client_id" => $this->appid,
	            "redirect_uri" => $this->callback,
	            "state" => $state,
	            "scope" => $this->scope
	        );			

	        $login_url =  $this->combineURL(self::GET_AUTH_CODE_URL, $keysArr);
	        header("Location:$login_url");
		}

		public function get_access(){
			if($this->CI->session->userdata('access_token')){
				return false;
			}
			$state = $this->CI->session->userdata('state');

			if(empty($state)){
				$state = $_SESSION['state'];
			}

			log_message('debug','access state:'.$state);
			//echo json_encode($this->CI->session->userdata('state'));
			if($state != $this->CI->input->get('state')){
				$this->set_error('state error!');
				return false;
			}
			
	        //-------请求参数列表
	        $keysArr = array(
	            "grant_type" => "authorization_code",
	            "client_id" => $this->appid,
	            "redirect_uri" => urlencode($this->callback),
	            "client_secret" => $this->appkey,
	            "code" => $this->CI->input->get('code')
	        );	

	        $token_url = $this->combineURL(self::GET_ACCESS_TOKEN_URL, $keysArr);	
	        $response = $this->get_contents($token_url);	

	        if(strpos($response, "callback") !== false){
	            $lpos = strpos($response, "(");
	            $rpos = strrpos($response, ")");
	            $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
	            $msg = json_decode($response);

	            if(isset($msg->error)){
	                $this->set_error($msg->error, $msg->error_description);
	            }
	        }

	        $params = array();
	        parse_str($response, $params);
	        $_SESSION['access_token'] = $params["access_token"];
       		$this->CI->session->set_userdata('access_token',$params["access_token"]);	        
		}

		public function get_openid(){
			if($this->CI->session->userdata('openid')){
				return $this->session->userdata('openid');
			}	

			$access_token = $_SESSION['access_token'];
	        //-------请求参数列表
	        $keysArr = array(
	            "access_token" => $access_token//$state = $this->CI->session->userdata('access_token')//$this->recorder->read("access_token")
	        );	        


	        $graph_url = $this->combineURL(self::GET_OPENID_URL, $keysArr);
	        $response = $this->get_contents($graph_url);

	        //--------检测错误是否发生
	        if(strpos($response, "callback") !== false){

	            $lpos = strpos($response, "(");
	            $rpos = strrpos($response, ")");
	            $response = substr($response, $lpos + 1, $rpos - $lpos -1);
	        }

	        $user = json_decode($response);
	        if(isset($user->error)){
	            $this->set_error($user->error, $user->error_description);
	        }
	        //------记录openid
	        if(isset($user->openid)){
	        	$_SESSION['openid'] = $user->openid;
		        $this->CI->session->set_userdata('openid',$user->openid);
		        return $user->openid;
	    	}else{
	    		return false;
	    	}
		}

		public function get_info(){
			$baseUrl = self::GET_USER_INFO;
			$argsList = array("format" => "json");
			$method = 'GET';
			$pre = "#";

            $keysArr = array(
                "oauth_consumer_key" => (int)$this->appid,
                "access_token" => $_SESSION['access_token'],//$this->CI->session->userdata('access_token'),
                "openid" => $_SESSION['openid']// $this->CI->session->userdata('openid')
            );		

            $optionArgList = array();//一些多项选填参数必选一的情形
	        foreach($argsList as $key => $val){
	            $tmpKey = $key;
	            $tmpVal = $val;

	            if(!is_string($key)){
	                $tmpKey = $val;

	                if(strpos($val,$pre) === 0){
	                    $tmpVal = $pre;
	                    $tmpKey = substr($tmpKey,1);
	                    if(preg_match("/-(\d$)/", $tmpKey, $res)){
	                        $tmpKey = str_replace($res[0], "", $tmpKey);
	                        $optionArgList[$res[1]][] = $tmpKey;
	                    }
	                }else{
	                    $tmpVal = null;
	                }
	            }

	            //-----如果没有设置相应的参数
	            if(!isset($arr[$tmpKey]) || $arr[$tmpKey] === ""){

	                if($tmpVal == $pre){//则使用默认的值
	                    continue;
	                }else if($tmpVal){
	                    $arr[$tmpKey] = $tmpVal;
	                }else{
	                    if($v = $_FILES[$tmpKey]){

	                        $filename = dirname($v['tmp_name'])."/".$v['name'];
	                        move_uploaded_file($v['tmp_name'], $filename);
	                        $arr[$tmpKey] = "@$filename";

	                    }else{
	                        $this->set_error("api调用参数错误","未传入参数$tmpKey");
	                    }
	                }
	            }

	            $keysArr[$tmpKey] = $arr[$tmpKey];
	        }

	        //检查选填参数必填一的情形
	        foreach($optionArgList as $val){
	            $n = 0;
	            foreach($val as $v){
	                if(in_array($v, array_keys($keysArr))){
	                    $n ++;
	                }
	            }

	            if(! $n){
	                $str = implode(",",$val);
	                $this->CI->set_error("api调用参数错误",$str."必填一个");
	            }
	        }

	        // if($method == "POST"){
	        //     if($baseUrl == "https://graph.qq.com/blog/add_one_blog") $response = $this->urlUtils->post($baseUrl, $keysArr, 1);
	        //     else $response = $this->post($baseUrl, $keysArr, 0);
	        // }else if($method == "GET"){
	            $response = $this->get($baseUrl, $keysArr);
	        //}
	        return json_decode($response);	        
		}

	    /**
	     * get_contents
	     * 服务器通过get请求获得内容
	     * @param string $url       请求的url,拼接后的
	     * @return string           请求返回的内容
	     */
	    public function get_contents($url){
	        if (ini_get("allow_url_fopen") == "1") {
	            $response = file_get_contents($url);
	        }else{
	            $ch = curl_init();
	            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	            curl_setopt($ch, CURLOPT_URL, $url);
	            $response =  curl_exec($ch);
	            curl_close($ch);
	        }

	        //-------请求为空
	        if(empty($response)){
	        	$this->CI->set_error('500001!');
	        }	        

	        return $response;
	    }		

	    public function combineURL($baseURL,$keysArr){
	        $combined = $baseURL."?";
	        $valueArr = array();

	        foreach($keysArr as $key => $val){
	            $valueArr[] = "$key=$val";
	        }

	        $keyStr = implode("&",$valueArr);
	        $combined .= ($keyStr);
	        
	        return $combined;
	    }	


	    //简单实现json到php数组转换功能
	    private function simple_json_parser($json){
	        $json = str_replace("{","",str_replace("}","", $json));
	        $jsonValue = explode(",", $json);
	        $arr = array();
	        foreach($jsonValue as $v){
	            $jValue = explode(":", $v);
	            $arr[str_replace('"',"", $jValue[0])] = (str_replace('"', "", $jValue[1]));
	        }
	        return $arr;
	    }

	    /**
	     * get
	     * get方式请求资源
	     * @param string $url     基于的baseUrl
	     * @param array $keysArr  参数列表数组      
	     * @return string         返回的资源内容
	     */
	    private function get($url, $keysArr){
	        $combined = $this->combineURL($url, $keysArr);
	        return $this->get_contents($combined);
	    }

	    /**
	     * post
	     * post方式请求资源
	     * @param string $url       基于的baseUrl
	     * @param array $keysArr    请求的参数列表
	     * @param int $flag         标志位
	     * @return string           返回的资源内容
	     */
	    private function post($url, $keysArr, $flag = 0){

	        $ch = curl_init();
	        if(! $flag) curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
	        curl_setopt($ch, CURLOPT_POST, TRUE); 
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $keysArr); 
	        curl_setopt($ch, CURLOPT_URL, $url);
	        $ret = curl_exec($ch);

	        curl_close($ch);
	        return $ret;
	    }	    
	}
?>