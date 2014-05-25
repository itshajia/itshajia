<?php
/**
 * 消息图文回复
 * @param $text
 * @param $web_url 站点url
 * @return array
 */
function reply( $text ) {
    global $uid, $openid;

    if( empty($text) ) {
        return "使用方法: \n身份证+空格+身份证号码 ";
    }
    $url = 'http://idquery.duapp.com/index.php';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "in_id={$text}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    $data = iconv("gbk","utf-8//IGNORE",$data);
    $startpostion = stripos($data,'发证地');
    $endpostion = stripos($data,'/form');
    $data = substr($data,$startpostion,$endpostion-$startpostion);
    $data = strip_tags($data);

    return  $data;
}


?>