<?php
if(!empty($_GET['n'])) {
    $key = file(__DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'key.txt');
    if(!empty($key[intval($_GET['n'])-1])){
        $url = getBaidu(trim($key[intval($_GET['n'])-1]));
        setcookie("BAIDUID","");
        setcookie("BIDUPSID","");
        setcookie("BD_UPN","");
        setcookie("BDORZ","");
        setcookie("H_PS_645EC","");
        setcookie("H_PS_PSSID","");
        if(is_array($url)){
            foreach ($url as $value) {
                $getUrl[]='<iframe src="'.$value.'" width="100%" height="50" security="restricted" sandbox="allow-forms allow-scripts allow-same-origin allow-popups"></iframe>';
            }
            echo implode($getUrl);
        }
    }
    echo '<script type="text/javascript">setTimeout(function(){window.location.href=\''.getHttpType().$_SERVER['HTTP_HOST'].'/index.php?n='.(!empty($key[intval($_GET['n'])])?(intval($_GET['n'])+1):1).'\';}, 15000);</script>';
}

function getCookie($url, $randIP) {
    if(file_exists(__DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'cookie.txt')) {
        @unlink(__DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'cookie.txt');
    }
    $ch = curl_init();
    $user_agent = 'Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Mobile/15A372 Safari/604.1';
    $options =  array(
        CURLOPT_URL => $url,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_NOBODY => FALSE,
        CURLOPT_HEADER => TRUE,
        CURLOPT_HTTPGET => TRUE,
        CURLOPT_REFERER => $url,
        CURLOPT_USERAGENT => $user_agent,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_FOLLOWLOCATION => TRUE,
        CURLOPT_SSL_VERIFYPEER => FALSE,
        CURLOPT_SSL_VERIFYHOST => FALSE,
        CURLOPT_COOKIEJAR => __DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'cookie.txt',
        CURLOPT_HTTPHEADER => array('Content-Type: text/plain', 'X-FORWARDED-FOR:' . $randIP, 'CLIENT-IP:' . $randIP),
    );
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    $Code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return array($result, $Code);
}

function getBaidu($srt) {
    $IP = getRandIP();
    $temp = getCookie('http://www.baidu.com/s?ie=utf-8&wd='.$srt.'&tn=baidu&pn=20&rn=50', $IP);
    preg_match('/<title>(.+?)<\/title>/is', $temp[0], $_title);
    if(!empty($_title[1])&&$_title[1] == '百度安全验证'){return 'IP已被屏蔽';}
    preg_match('/bds\.comm\.eqid = \"(.+?)\"/is', $temp[0], $eqid);
    preg_match_all('/url\":\"http:\/\/www\.baidu\.com\/link\?url=(.+?)\"/is', $temp[0], $linkUrl);
    foreach ($linkUrl[1] as $value) {
        $url[] = 'http://www.baidu.com/link?url='.$value.'&wd=https://www.baidu.com&eqid='.$eqid[1];
    }
    return (!empty($url)&&is_array($url)?$url:0);
}

function getRandIP() {
    $ip2id= round(rand(600000, 2550000) / 10000);
    $ip3id= round(rand(600000, 2550000) / 10000);
    $ip4id= round(rand(600000, 2550000) / 10000);
    $_array = array('218','218','66','66','218','218','60','60','202','204','66','66','66','59','61','60','222','221','66','59','60','60','66','218','218','62','63','64','66','66','122','211');
    $randarr= mt_rand(0,count($_array)-1);
    $ip1id = $_array[$randarr];
    return $ip1id.'.'.$ip2id.'.'.$ip3id.'.'.$ip4id;
}

function getHttpType(){
    $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
    return $http_type;
}
