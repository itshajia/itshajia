<?php
/**
 * 消息图文回复
 * @param $text
 * @param $web_url 站点url
 * @return array
 */
function getCity() {
    global $uid, $openid;

    $UserInfo = M('UserInfo');
    $map = array();
    $map['uid'] = $uid;
    $obj = $UserInfo->where($map)->find();
    $appId = $obj['appId'];
    $appSecret = $obj['appSecret'];

    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appId."&secret=".$appSecret;
    $result = file_get_contents($url);
    $jsoninfo = json_decode($result, true);
    $access_token = $jsoninfo['access_token'];

    $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
    $result = file_get_contents($url);
    $jsoninfo = json_decode($result, true);

    return $jsoninfo['city'];
}

function reply( $text ) {
    global $uid, $openid;

    $msg = '

其他城市查询：
输入天气+空格+城市名称';

    $text = trim($text);
    if ( !$text ) {
        //return '1212';
        $GlobalLocation = M('GlobalLocation');
        $map = array();
        $map['uid'] = $uid;
        $map['openid'] = $openid;

        $pos = $GlobalLocation->where($map)->find();

        if ( $pos && $pos['x'] && $pos['y'] ) {
            $url = "http://api.map.baidu.com/geocoder?location=".$pos['x'].",".$pos['y']."&output=json&key=WdHwL7WN2wUbz6vzPBXx9M0t";
            $result=https_get($url);
            $jsoninfo = json_decode($result, true);
            $text = $jsoninfo['result']['addressComponent']['city'];
            $text = substr($text, 0, strpos($text, '市', 0));
        } else {
            $text = getCity();
        }
    }

    $url = 'http://api2.sinaapp.com/search/weather/?appkey=0020130430&appsecert=fa6095e113cd28fd&reqtype=text&keyword='.urlencode($text);
    $result = file_get_contents($url);
    $jsoninfo = json_decode($result, true);
    return $jsoninfo['text']['content'].$msg;
}


?>