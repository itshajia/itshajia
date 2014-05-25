<?php
/**
 * 消息图文回复
 * @param $text
 * @param $web_url 站点url
 * @return array
 */
function reply( $text ) {
    global $uid, $openid;

    if(empty($text)) {
        return "使用方法: \n梦见+空格+具体内容 如（梦见 情人）";
    }

    $apihost = "http://api2.sinaapp.com/";
    $apimethod = "search/dream/?";
    $apiparams = "appkey=0020130430&appsecert=fa6095e113cd28fd&reqtype=text";
    $apikeyword = "&keyword=".urlencode($text);
    $apicallurl = $apihost.$apimethod.$apiparams.$apikeyword;

    $api2str = file_get_contents($apicallurl);
    $api2json = json_decode($api2str, true);
    $contentStr = $api2json['text']['content'];
    return $contentStr;
}


?>