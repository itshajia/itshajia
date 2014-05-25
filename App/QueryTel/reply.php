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
        return "使用方法: \n归属地+空格+手机号码 \n 示例：归属地 123456789";
    }
    $url = 'http://webservice.webxml.com.cn/WebServices/MobileCodeWS.asmx/getMobileCodeInfo';
    $number = $text;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "mobileCode={$number}&userId=");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    $data = simplexml_load_string($data);
    if (strpos($data, 'http://')) {
        $data='输入错误,请参考: 归属地+空格+手机号码';
    }else{
        $dataarr=explode("：",$data);
        $data=$dataarr[1];
    }
    return $data;
}


?>