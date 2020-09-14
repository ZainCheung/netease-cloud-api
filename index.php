<?php
error_reporting(0);
class API{

    // General
    protected $_MINI_MODE=false;
    protected $_MODULUS='00e0b509f6259df8642dbc35662901477df22677ec152b5ff68ace615bb7b725152b3ab17a876aea8a5aa76d2e417629ec4ee341f56135fccf695280104e0312ecbda92557c93870114af6c9d05c4f7f0c3685b7a46bee255932575cce10b424d813cfe4875d3e82047b97ddef52741d546b8e289dc6935b3ece0462db0a22b8e7';
    protected $_NONCE='0CoJUm6Qyw8W8jud';
    protected $_PUBKEY='010001';
    protected $_VI='0102030405060708';
    protected $_USERAGENT='Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.157 Safari/537.36';
    protected $_COOKIE='os=pc; osver=Microsoft-Windows-10-Professional-build-10586-64bit; appver=2.0.3.131777; channel=netease; __remember_me=true;';
    protected $_REFERER='http://music.163.com/';
    // use static secretKey, without RSA algorithm
    protected $_secretKey='TA3YiYCfY2dDJQgg';
    protected $_encSecKey='84ca47bca10bad09a6b04c5c927ef077d9b9f1e37098aa3eac6ea70eb59df0aa28b691b7e75e4f1f9831754919ea784c8f74fbfadf2898b0be17849fd656060162857830e241aba44991601f137624094c114ea8d17bce815b0cd4e5b8e2fbaba978c6d1d14dc3d1faf852bdd28818031ccdaaa13a6018e1024e2aae98844210';

    // encrypt mod
    protected function prepare($raw){
        $data['params']=$this->aes_encode(json_encode($raw),$this->_NONCE);
        $data['params']=$this->aes_encode($data['params'],$this->_secretKey);
        $data['encSecKey']=$this->_encSecKey;
        return $data;
    }
    protected function aes_encode($secretData,$secret){
        return openssl_encrypt($secretData,'aes-128-cbc',$secret,false,$this->_VI);
    }

    // CURL
    protected function curl($url,$data=null,$cookie=false){
        $curl=curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        if($data){
            if(is_array($data))$data=http_build_query($data);
            curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
            curl_setopt($curl,CURLOPT_POST,1);
        }
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl,CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl,CURLOPT_REFERER,$this->_REFERER);
        curl_setopt($curl,CURLOPT_COOKIE,$this->_COOKIE."__csrf=".$_COOKIE["__csrf"]."; MUSIC_U=".$_COOKIE["MUSIC_U"]);
        curl_setopt($curl,CURLOPT_USERAGENT,$this->_USERAGENT);
        if($cookie==true){
        curl_setopt($curl,CURLOPT_HEADER,1);
        $result=curl_exec($curl);
        preg_match_all('/\{(.*)\}/', $result, $json);
        if(json_decode($json[0][0],1)["code"]==200){
            preg_match_all('/Set-Cookie: MUSIC_U=(.*?)\;/', $result, $musicu);
            preg_match_all('/Set-Cookie: __csrf=(.*?)\;/', $result, $csrf);
            setcookie("MUSIC_U",$musicu[1][0]);
            setcookie("__csrf",$csrf[1][0]);
        }
        $result = $json[0][0];
        }else{
        $result=curl_exec($curl);}
        curl_close($curl);
        return $result;
    }

    // main function
    public function index(){
        $string = file_get_contents("help.html");
        // echo $string;
        return $string;
    }
    // login by phone
    public function login($cell,$pwd,$countrycode){
        $url="https://music.163.com/weapi/login/cellphone";
        $data=array(
        "phone"=>$cell,
        "countrycode"=>"86",
        "countrycode"=>$countrycode,
        "password"=>$pwd,
        "rememberLogin"=>"true");
        return $this->curl($url,$this->prepare($data),true);
    }
    // login by email
    public function loginByEmail($cell,$pwd){
        $url="https://music.163.com/weapi/login";
        $data=array(
        "username"=>$cell,
        "password"=>$pwd,
        "rememberLogin"=>"true");
        return $this->curl($url,$this->prepare($data),true);
    }
    // get user detail
    public function detail($uid){
        $url="https://music.163.com/weapi/v1/user/detail/${uid}";
        return $this->curl($url,$this->prepare($data),true);
    }
    public function follow(){
        $url="https://music.163.com/weapi/user/follow/0";
        return '{"code":'.json_decode($this->curl($url,$this->prepare(array('csrf_token'=>$_COOKIE["__csrf"]))),1)["code"].'}';
    }
    public function recommend(){
        $url="https://music.163.com/weapi/v1/discovery/recommend/resource";
        $json = json_decode($this->curl($url,$this->prepare(array('csrf_token'=>$_COOKIE["__csrf"]))), 1);
		foreach ($json["recommend"] as $i => $k) {
			$id[$i] = $k["id"];
		}
		return $id;
        
    }
    // 获取推荐歌单
    public function personalized($limit){
        $url="https://music.163.com/weapi/personalized/playlist";
        $data=array(
            "limit"=>$limit,
            "total"=>"true",
            "n"=>1000,);
        $json = json_decode($this->curl($url,$this->prepare($data),true),1);
		foreach ($json["result"] as $i => $k) {
			$id[$i] = $k["id"];
		}
		return $id;
    }
    public function daka_new(){
        //$playlist = $this->recommend();
        $playlist = $this->personalized(100);
        $ids = array();
        $count=0;
        for ($i = 0; sizeof($ids) < 1000; $i++) {
        	$songid = $this->getsongid($playlist[rand(0,sizeof($playlist)-1)]);
        	for ($k=0;sizeof($ids) < 1000&&$k<sizeof($songid);$k++) {
        	
        	$ids[$count]["action"]="play";
        	$ids[$count]["json"]["download"] =0 ;
        	$ids[$count]["json"]["end"] ="playend"; 
     		$ids[$count]["json"]["id"] = $songid[$k]["id"];
     		$ids[$count]["json"]["sourceId"] ="";
     		$ids[$count]["json"]["time"] = 240;
     		$ids[$count]["json"]["type"] ="song";
     		$ids[$count]["json"]["wifi"] =0;
     		$count++;
    	    }
        }
        $data =json_encode($ids);
        $url = "http://music.163.com/weapi/feedback/weblog";
        $this->curl($url,$this->prepare(array("logs"=>$data)));
        return '{"code":200,"count":'.$count.'}';
    }
    public function listen($id,$time){
        $ids = array();
        $count=0;
        $t=1;
    	$songid = $this->getsongid($id);
    	while($t <= $time){
    	    foreach ($songid as $index => $trackId) {
    			$ids[$count]["action"]="play";
            	$ids[$count]["json"]["download"] =0 ;
            	$ids[$count]["json"]["end"] ="playend"; 
         		$ids[$count]["json"]["id"] = $trackId["id"];
         		$ids[$count]["json"]["sourceId"] ="";
         		$ids[$count]["json"]["time"] = 240;
         		$ids[$count]["json"]["type"] ="song";
         		$ids[$count]["json"]["wifi"] =0;
         		$count++;
    		}
    		$t++;
    	}
        $data =json_encode($ids);
        $url = "http://music.163.com/weapi/feedback/weblog";
        $this->curl($url,$this->prepare(array("logs"=>$data)));
        return '{"code":200,"count":'.$count.'}';
    }
    public function getsongid($playlist_id){
        $url='https://music.163.com/weapi/v3/playlist/detail?csrf_token=';
        $data=array(
            'id'=>$playlist_id,
            'n'=>1000,
            'csrf_token'=>'',
        );
        $raw=$this->curl($url,$this->prepare($data));
        $json=json_decode($raw,1);
      	
		return $json["playlist"]["trackIds"];
        //return json_decode($raw,1)[];
    }
    
    
    
    
    public function daka(){
        $playlist = $this->recommend();
        $ids = array();
        for ($i = 0; sizeof($ids) < 300; $i++) {
        	$songid = $this->playlist($playlist[rand(0,sizeof($playlist))]);
        	foreach ($songid as $id) {
     		$ids[] = $id;
    	    }
        }
        return '{"code":200,"count":'.$this->scrobble($ids).'}';
    }
    public function sign(){
        $url="https://music.163.com/weapi/point/dailyTask";
        $data=array("type"=>0);
        return $this->curl($url,$this->prepare($data),true);
    }
    public function scrobble($songid){
        $url="http://music.163.com/weapi/feedback/weblog";
        $res = array();
        $count=0;
        $cookies=$this->_COOKIE."__csrf=".$_COOKIE["__csrf"]."; MUSIC_U=".$_COOKIE["MUSIC_U"];
		$mh = curl_multi_init();
		foreach ($songid as $k => $id) {
   	        $data[$k]=$this->prepare(array("logs"=>'[{"action":"play","json":{"download":0,"end":"playend","id":"'.$id.'","sourceId":"","time":240,"type":"song","wifi":0}}]'));
            $data[$k]=http_build_query($data[$k]);
			$conn[$k] = curl_init($k);
			curl_setopt($conn[$k], CURLOPT_URL, $url);
			curl_setopt($conn[$k],CURLOPT_POST,1);
			curl_setopt($conn[$k],CURLOPT_POSTFIELDS,$data[$k]);
			//curl_setopt($conn[$k], CURLOPT_TIMEOUT, $timeout);
			curl_setopt($conn[$k], CURLOPT_COOKIE, $cookies);
			curl_setopt($conn[$k], CURLOPT_RETURNTRANSFER, 1);
			curl_multi_add_handle($mh, $conn[$k]);
			$count++;
		}
		do {
			$mrc = curl_multi_exec($mh, $active);
		}
		while ($mrc == CURLM_CALL_MULTI_PERFORM);
		while ($active and $mrc == CURLM_OK) {
			if (curl_multi_select($mh) != -1) {
				do {
					$mrc = curl_multi_exec($mh, $active);
				}
				while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}
		}
		foreach ($array as $k => $value) {
			curl_error($conn[$k]);
			$res[$k] = curl_multi_getcontent($conn[$k]);
			//$header[$k] = curl_getinfo($conn[$k]);
			curl_close($conn[$k]);
			curl_multi_remove_handle($mh, $conn[$k]);
		}
		curl_multi_close($mh);
		//return array('return' => $res, 'header' => $header);
        //return "233";
        return $count;
    }

    public function playlist($playlist_id){
        $url='https://music.163.com/weapi/v3/playlist/detail?csrf_token=';
        $data=array(
            'id'=>$playlist_id,
            'n'=>1000,
            'csrf_token'=>'',
        );
        $raw=$this->curl($url,$this->prepare($data));
        $json=json_decode($raw,1);
      	foreach ($json["playlist"]["trackIds"] as $i => $k) {
			$ids[$i] = $k["id"];
		}
		return $ids;
        //return json_decode($raw,1)[];
    }
}
$api= new API();
$api->follow();
//test();
if($_REQUEST["do"]=="login"){
echo $api->login($_REQUEST["uin"],$_REQUEST["pwd"],$_REQUEST["countrycode"]);}
elseif($_REQUEST["do"]=="email"){echo $api->loginByEmail($_REQUEST["uin"],$_REQUEST["pwd"]);}
elseif($_REQUEST["do"]=="sign"){echo $api->sign();}
elseif($_REQUEST["do"]=="daka"){echo $api->daka_new();}
elseif($_REQUEST["do"]=="check"){echo $api->follow();}
elseif($_REQUEST["do"]=="detail"){echo $api->detail($_REQUEST["uid"]);}
elseif($_REQUEST["do"]=="listen"){echo $api->listen($_REQUEST["id"],$_REQUEST["time"]);}
else{echo $api->index();}
?>